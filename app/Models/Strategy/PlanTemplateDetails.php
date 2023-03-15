<?php

namespace App\Models\Strategy;

use App\Abstracts\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanTemplateDetails extends Model
{
    use HasFactory, SoftDeletes;

    public $htmlTree;

    protected $fillable = [
        'plan_template_id',
        'parent_id',
        'level',
        'order',
        'name',
        'indicators',
        'poa_indicators',
        'program',
        'articulations',
        'cre_objective',
        'company_id',
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->name = mb_strtoupper($model->name);
        });
        static::updating(function ($model){
            $model->name = mb_strtoupper($model->name);
        });
    }

    /**
     * Get the parent element
     *
     * @return BelongsTo
     */
    public function parentElement()
    {
        return $this->belongsTo(PlanTemplateDetails::class, 'parent_id');
    }

    /**
     * Get the PLAN TEMPLATE
     *
     * @return BelongsTo
     */
    public function planTemplate()
    {
        return $this->belongsTo(PlanTemplate::class, 'plan_template_id');
    }

    /**
     * Get total number of nodes of given level
     *
     * @param $level
     * @param $planTemplateId
     * @return mixed
     */
    public function nodeCount($level, $planTemplateId)
    {
        return $this->where('level', $level)->where('plan_template_id', $planTemplateId)->count();
    }

    /**
     * Get element level
     *
     * @param $id
     * @return mixed
     */
    public function getLevel($id)
    {
        return $this->find($id)->level;
    }

    /**
     * Get detail template structure
     *
     * @param $planTemplateId
     * @return array
     */
    public function getElements($planTemplateId)
    {
        $spaces = 2;
        $elementsArray = array();
        $elements = $this->where('plan_template_id', $planTemplateId)->whereNull('parent_id')->orderBy('order')->get();
        $this->htmlTree = <<<cre
<ul role="group">
cre;

        foreach ($elements as $element) {
            $hasChildren = $this->hasChildren($element->id);
            $elementAttribute = $hasChildren ? 'class="parent_li" role="treeitem"' : 'style="display: list-item;"';
            $nameAttribute = $hasChildren ? 'class="fa fa-lg fa-minus-circle"' : 'class="icon-leaf"';
            $this->htmlTree .= <<<cre
<li $elementAttribute>
    <span><i $nameAttribute></i> <a wire:click="elementEdition($element->id)" href="#" data-toggle="modal" data-target="#edition-modal-element">$element->name</a></span>
cre;
            array_push(
                $elementsArray,
                ['id' => $element->id,
                    'name' => str_pad('', $spaces, '-') . $element->name,
                    'parentNode' => $hasChildren,
                    'level' => $element->level]
            );
            $this->getSubElements($elementsArray, $planTemplateId, $element->id, $spaces + 2);
            $this->htmlTree .= <<<cre
    </li>
cre;
        }
        $this->htmlTree .= <<<cre
</ul>
cre;

        return $elementsArray;
    }

    /**
     * Get detail template structure recursive
     *
     * @param $elementsArray
     * @param $planTemplateId
     * @param $parentId
     * @param $spaces
     */
    private function getSubElements(&$elementsArray, $planTemplateId, $parentId, $spaces)
    {
        $elements = $this->where('plan_template_id', $planTemplateId)->where('parent_id', $parentId)->orderBy('order')->get();
        if($elements->count()) {
            $this->htmlTree .= '<ul role="group">';
        }
        foreach ($elements as $element) {
            $hasChildren = $this->hasChildren($element->id);
            $elementAttribute = $hasChildren ? 'class="parent_li" role="treeitem"' : 'style="display: list-item;"';
            $nameAttribute = $hasChildren ? 'class="fa fa-lg fa-minus-circle"' : 'class="icon-leaf"';
            $this->htmlTree .= <<<cre
<li $elementAttribute>
    <span><i $nameAttribute></i> <a wire:click="elementEdition($element->id)" href="#" data-toggle="modal" data-target="#edition-modal-element">$element->name</a></span>
cre;
            array_push(
                $elementsArray,
                ['id' => $element->id,
                    'name' => str_pad('', $spaces, '-') . $element->name,
                    'parentNode' => $this->hasChildren($element->id),
                    'level' => $element->level]
            );
            $this->getSubElements($elementsArray, $planTemplateId, $element->id, $spaces + 2);
            $this->htmlTree .= <<<cre
</li>
cre;
        }
        if($elements->count()) {
            $this->htmlTree .= '</ul>';
        }
    }

    /**
     * Checks if an element has children
     *
     * @param $parent_id
     * @return mixed
     */
    public function hasChildren($parent_id)
    {
        return $this->where('parent_id', $parent_id)->count();
    }
}
