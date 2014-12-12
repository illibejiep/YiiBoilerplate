<script>
    modelData['<?=$relationName;?>'] = <?=json_encode($relationList);?>
</script>
<div
    data-model="<?=get_class($model);?>"
    data-relation-model="<?=$relationModel;?>"
    data-relation-name="<?=$relationName;?>"
    data-is-multiple="<?=$isMultiple;?>"
    class="relationField"
    style="border: 1px solid black"
>
    <input type="hidden" name="<?=get_class($model);?>[<?=$relationName;?>]">
    <ul class="relations">
    </ul>
    <input class="ajax_search" />
    <div class="ajax_result" style="position: absolute;background: #ffffff;border: 1px solid black;width: 250px;display:none;">
        <span class="close" style="float: right;margin-right: 5px;cursor: pointer;">x</span>
        <ul>
        </ul>
    </div>

    <div class="templates" style="display: none;">
        <li data-id="" class="relations_list_tpl">
            <span class="model_name"></span>
            <span class='remove' style='color: red;cursor: pointer'>X</span>
            <input type='hidden' name="<?=get_class($model);?>[<?=$relationName;?>][]" value="">
        </li>
        <li data-id="" data-name="" class="ajax_result_tpl">
            <span class="model_name"></span>
            <span class='add_relation' style='color: red;cursor: pointer'>+</span>
        </li>
    </div>

</div>