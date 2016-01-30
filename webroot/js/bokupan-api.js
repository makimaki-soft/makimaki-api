var BokupanAPI= function(){

    var base_url = "/makimaki-api/bokupan";

    return {
        /*
         * @param _post_data : POSTするデータ
         * @param _done      : 成功時に実行する関数
         * @param _fail      : 失敗示に実行する関数
         */
        addRoom : function(_post_data, _done, _fail){
            $.ajax({
                url      : base_url + "/add",
                type     : "POST",
                data     : _post_data,
                dataType : "json",
            }).done(function(data) {
                _done(data);
            }).fail(function(){
                _fail();
            });
        }
    }
}();