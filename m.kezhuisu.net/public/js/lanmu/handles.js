
window.onload = function() {
    baguetteBox.run('.baguetteBoxOne');
};

var SUBMIT_FORM = true;//防止多次点击提交
$(function(){
    //红星点赞
    $(document).on("click",".red_heart",function(){
        var obj = $(this);
        SUBMIT_FORM = false;//标记为已经提交过
        var layer_index = layer.load();
        var pro_unit_id = obj.data("pro_unit_id");
        var record_id = obj.data("record_id");
        var red_heart = obj.data("red_heart");
        if(pro_unit_id == '' || record_id == ''){
            layer.msg('生产单元id或记录id有误!');
            SUBMIT_FORM = true;
            layer.close(layer_index);//手动关闭
            return false;

        }

        //		{ {--window.location = "{ { url('/antifake/' . $pro_unit_id) }}/" + label_num;--}}
        var data = {'pro_unit_id' : pro_unit_id,'record_id' : record_id};
        console.log(data);
        var layer_index = layer.load();
        $.ajax({
            'type' : 'POST',
            'url' : RECORD_HEART_URL,
            'data' : data,
            'dataType' : 'json',
            'success' : function(ret){
                console.log(ret);
                if(!ret.apistatus){//失败
                    SUBMIT_FORM = true;//标记为未提交过
                    //alert('失败');
                    layer.alert(ret.errorMsg, {icon: 5});
                    // err_alert(ret.errorMsg);
                }else{//成功
                    layer.msg('非常感谢您的点赞!', function(){
                        red_heart = red_heart + 1;
                        obj.data("red_heart",red_heart);
                        obj.find(".red_heart_num").html(red_heart);
                        // location.reload();
                    });
                    // layer.alert('提交成功!', {icon: 6});
                    // { {--go("{ {url('inputcls/')}}");--}}
                    // var supplier_id = ret.result['supplier_id'];
                    //if(SUPPLIER_ID_VAL <= 0 && judge_integerpositive(supplier_id)){
                    //    SUPPLIER_ID_VAL = supplier_id;
                    //    $('input[name="supplier_id"]').val(supplier_id);
                    //}
                    // save_success();
                }
                layer.close(layer_index)//手动关闭
            }
        });
        layer.close(layer_index);//手动关闭
        SUBMIT_FORM = true;//标记为已经提交过
        return false;
    })

});