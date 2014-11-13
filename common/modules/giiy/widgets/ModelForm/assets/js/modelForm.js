$(
    function() {

        form = $('form.modelForm');

        form.submit(function(){form.find('.templates').remove();});

        form.on('click','.remove',function(){
            $(this).parent().remove();
        });

        form.on('click','.close',function(){
            $(this).parent().hide();
        });

        form.on('click','.add_relation',function(){

            var fieldDiv = $(this).closest('.relationField');
            var modelLi = $(this).parent();
            var id = modelLi.attr('data-id');
            var name = modelLi.attr('data-name');
            var relationsList = fieldDiv.find('.relations_list_tpl').clone().removeClass('relations_list_tpl');
            relationsList.attr('data-id',id);
            relationsList.find('input').val(id);
            relationsList.attr('data-name',name);
            relationsList.find('.model_name').html(name);
            fieldDiv.find('.relations').append(relationsList);
            modelLi.remove();

            if (modelLi.parent().children().length == 0)
                fieldDiv.find('.ajax_result').hide();

            var relationName = fieldDiv.attr('data-relation-name');
            modelData[relationName][id] = name;
        });

        form.on('keyup','.ajax_search',function() {

            var fieldDiv = $(this).parent();
            var relationModel = fieldDiv.attr('data-relation-model');
            var relationName = fieldDiv.attr('data-relation-name');
            var model = fieldDiv.attr('data-model');
            var query = $(this).val();
            var addr = '/' + relationModel;

            if (relationModel == 'GiiyPicture' || relationModel == 'GiiyVideo')
                addr = '/giiy' + addr;

            var ajaxResultTpl = fieldDiv.find('.ajax_result_tpl');

            $.post(
                addr,
                {
                    q:query
                },
                function(data) {
                    fieldDiv.find('.ajax_result ul').html('');
                    fieldDiv.find('.ajax_result').show();
                    for (i in data) {

                        if(modelData[relationName][data[i].id] !== undefined)
                            continue;


                        ajaxResult = ajaxResultTpl.clone().removeClass('ajax_result_tpl');
                        ajaxResult.attr('data-id',data[i].id);
                        ajaxResult.attr('data-name',data[i]._viewName);
                        ajaxResult.find('.model_name').html(data[i]._viewName);
                        fieldDiv.find('.ajax_result ul').append(ajaxResult);
                    }

                    if (data.length == 0)
                        fieldDiv.find('.ajax_result ul').append('<li>nothing...</li>')
                },
            'json');
        });


        form.find('.relationField').each(function(){

            var fieldDiv = $(this);
            var relationModel = fieldDiv.attr('data-relation-model');
            var relationName = fieldDiv.attr('data-relation-name');

            for (var id in modelData[relationName]) {
                var name = modelData[relationName][id];
                var relationsList = fieldDiv.find('.relations_list_tpl').clone().removeClass('relations_list_tpl');
                relationsList.attr('data-id',id);
                relationsList.find('input').val(id);
                relationsList.attr('data-name',name);
                relationsList.find('.model_name').html(name);
                fieldDiv.find('.relations').append(relationsList);
            }

        });
    }
);