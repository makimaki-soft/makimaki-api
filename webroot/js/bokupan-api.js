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

        /*
         * @param _post_data : POSTするデータ
         * @param _done      : 成功時に実行する関数
         * @param _fail      : 失敗示に実行する関数
         */
        , editRoom : function(_post_data, _done, _fail){
            $.ajax({
                url      : base_url + "/edit",
                type     : "POST",
                data     : _post_data,
                dataType : "json",
            }).done(function(data) {
                _done(data);
            }).fail(function(){
                _fail();
            });
        }

        /*
         * @param _post_data : POSTするデータ
         * @param _done      : 成功時に実行する関数
         * @param _fail      : 失敗示に実行する関数
         */
        , deleteRoom : function(_post_data, _done, _fail){
            $.ajax({
                url      : base_url + "/delete",
                type     : "POST",
                data     : _post_data,
                dataType : "json",
            }).done(function(data) {
                _done(data);
            }).fail(function(){
                _fail();
            });
        }

        /*
         * @param _done      : 成功時に実行する関数
         * @param _fail      : 失敗示に実行する関数
         */
        , getRoomList : function(_done, _fail){
            $.ajax({
                url      : base_url + "/list",
                type     : "POST",
                dataType : "json",
            }).done(function(data) {
                _done(data);
            }).fail(function(){
                _fail();
            });
        }
    }
}();