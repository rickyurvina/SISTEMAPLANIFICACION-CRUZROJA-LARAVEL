<?php

namespace App\Http\Controllers\Strategy;

class ItemsHelper
{

    private $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function htmlList()
    {
        return $this->htmlFromArray($this->itemArray());
    }

    public function treeArray()
    {
        return $this->arrayFromArray($this->itemArray());
    }


    private function itemArray()
    {
        $result = array();
        foreach ($this->items->get() as $item) {
            if ($item->parent_id == null) {
                $result[$item->name] =
                    [
                        'id' => $item->id,
                        'objective_name' => $item->planRegistered->name,
                        'level' => $item->level,
                        'name' => $item->name,
                        'full_code' => $item->full_code,
                        'children' => $this->itemWithChildren($item)
                    ];
            }
        }
        return $result;
    }

    private function itemWithChildren($item)
    {
        $result = array();
        $children = $this->childrenOf($item);
        foreach ($children as $child) {
            $result[$child->name] =
                [
                    'id' => $child->id,
                    'level' => $child->level,
                    'objective_name' =>  $child->planRegistered->name,
                    'name' => $child->name,
                    'full_code' => $item->full_code,
                    'children' => $this->itemWithChildren($child),
                ];
        }
        return $result;
    }

    private function childrenOf($item)
    {
        $result = array();
        foreach ($item->children()->get() as $i) {
            if ($i->parent_id == $item->id) {
                $result[] = $i;
            }
        }
        return $result;
    }


    private function htmlFromArray($array)
    {
        $html = '';
        foreach ($array as $k => $v) {
            $html .= "<li>" . "<a href='#' class='waves-effect waves-themed'>" .
                "<span class='nav-link-text'>" . $k . "</span><strong class='dl-ref bg-success-500'>&nbsp;" . count($v) . "&nbsp;</strong>" .
                "</a>" . "<ul>" . "</li>";
            if (count($v) > 0) {
                $html .= $this->htmlFromArray($v);
            }
            $html .= "</ul>";
        }
        return $html;
    }

    private function arrayFromArray($array)
    {
        return $array;
    }
}