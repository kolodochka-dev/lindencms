<?php

namespace LindenCMS\Cms\Contexts\Node\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;

class Save extends DatabaseContext
{
    public function related(): array
    {
        return $this->node->props(
            fn($item) => $item->_database() && !$item->_database()->exclude
        );
    }

    public function __invoke(mixed $data = null)
    {
        $row = $this->node->ctx()->db_row($data);

        if ($this->node->id->get()) {
            // Update
            $this->query($this->node)
                ->where('id', $this->node->id->get())
                ->update($row);
        } else {
            // Insert
            $id = $this->query($this->node)
                ->insertGetId($row);
            $this->node->id->set($id);
        }

        if (isset($row['updated_at'])/*  && !$this->node->updated_at->_database()->exclude */) {
            $this->node->updated_at->set($row['updated_at']->format('Y-m-d H:i:s'));
        }

        if (isset($row['created_at'])/*  && !$this->node->created_at->_database()->exclude */) {
            $this->node->created_at->set($row['created_at']->format('Y-m-d H:i:s'));
        }

        foreach ($this->related() as $related) {
            $related->ctx()->db_save($data[$related->getParentPropertyName()] ?? []);
        }
    }
}
