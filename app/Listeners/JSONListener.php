<?php

namespace App\Listeners;

use App\Models\Item;
use App\Models\Player;
use JsonStreamingParser\Listener\ListenerInterface as ParserListener;

class JSONListener implements ParserListener
{
    protected $objectBuffer = [];
    protected $bufferSize = 8000;
    private $jsonObject = [];
    private $currentKey = null;
    private $currentAttributeChanges = [];
    private $currentChange = null;
    private $attributeChanges = null;
    private $isInAttributeChanges = [];
    private $isInNewlyAdded = [];
    private $isInPositionChanges = [];

    public function __construct($objectBuffer)
    {
        $this->objectBuffer = $objectBuffer;
    }
    public function getJsonPath()
    {
        return '/'; // you need to specify the path here
    }

    public function consume($objectBuffer)
    {
        $this->objectBuffer = $objectBuffer;
    }
    public function startObject(): void
    {
        if ($this->currentKey === 'changes') {
            // Start a new object within the 'changes' array
            $this->currentChange = [];
        } else {
            $this->jsonObject = [];
        }
    }

    public function whitespace(string $whitespace): void
    {
    }
    public function startDocument(): void
    {
        $this->objectBuffer = [];
    }
    public function endDocument(): void
    {
        // w00t!
    }
    public function startArray(): void
    {
        // handle start of an array here, if needed
        if ($this->currentKey == 'changes') {
            // Start a new array for 'changes'
            $this->currentAttributeChanges = [];
        } else if ($this->currentKey) {
            $this->jsonObject[$this->currentKey] = [];
        }
    }

    public function endArray(): void
    {
        // handle end of an array here, if needed
    }
    public function start_object()
    {
        if ($this->currentKey == 'changes') {
            // Start a new object within the 'changes' array
            $this->currentAttributeChanges = [];
        } else {
            $this->jsonObject = [];
        }
    }

    public function endObject(): void
    {
        if ($this->currentChange !== null) {
            // If we are in a 'changes' object, we've finished parsing it.
            $this->currentAttributeChanges['changes'][] = $this->currentChange;
            $this->currentChange = null;
        } elseif ($this->currentAttributeChanges !== null) {
            // If we are in an 'attribute_changes' object, we've finished parsing it.
            $this->jsonObject['attribute_changes'][] = $this->currentAttributeChanges;
            $this->currentAttributeChanges = null;
        } else {
            // We've finished parsing an object that is not part of 'changes' or 'attribute_changes'
            $this->objectBuffer[] = $this->jsonObject;

            if (count($this->objectBuffer) >= $this->bufferSize) {
                $this->processBuffer();
            }

            $this->jsonObject = [];
        }
    }



    public function file_position($position)
    {
        // handle the file position here, if needed
    }

    public function process($data)
    {
        // handle the processed data here
    }

    public function endOfDocument()
    {
        // handle the end of the document here
        if (count($this->objectBuffer) > 0) {
            $this->processBuffer();
        }
    }

    private function processBuffer()
    {
        foreach ($this->objectBuffer as $jsonObject) {
            foreach ($jsonObject['attribute_changes'] as $attributeChange) {
                $obfuscated_id = $attributeChange['obfuscated_id'];
                $current_rank = $attributeChange['current_rank'];
                $current_rarity = $attributeChange['current_rarity'];
                $item = Item::byUUID($obfuscated_id)->first();
                $player = Player::byUUID($obfuscated_id)->first();
                $item->ovr = $current_rank;
                $item->rarity = $current_rarity;
                $item->save();
                foreach ($attributeChange['changes'] as $change) {
                    $name = $change['name'];
                    $current_value = $change['current_value'];
                    if ($name == 'CON R') {
                    }
                    // Here you have access to $obfuscated_id, $current_rank, $current_rarity, $name, and $current_value.
                    // You can process or store these values as needed.
                }
            }

            $this->objectBuffer = [];
        }
    }


    public function key(string $key): void
    {
        $this->currentKey = $key;
        if ($this->currentKey === 'attribute_changes') {
            $this->isInAttributeChanges = true;
        } elseif ($this->currentKey === 'newly_added') {
            $this->isInNewlyAdded = true;
        } elseif ($this->currentKey === 'position_changes') {
            $this->isInPositionChanges = true;
        }
    }

    public function value($value): void
    {
        if ($this->currentKey !== null) {
            if ($this->currentChange !== null) {
                // If we're within a 'changes' object, add the value to it
                $this->currentChange[$this->currentKey] = $value;
            } else if ($this->attributeChanges !== null) {
                // If we're within an 'attribute_changes' object, add the value to it
                $this->attributeChanges[$this->currentKey] = $value;
            } else {
                // If we're not within 'changes' or 'attribute_changes', add the value to the current JSON object
                $this->jsonObject[$this->currentKey] = $value;
            }
            $this->currentKey = null;
        }
    }
}
