<?= $this->Html->script('jquery-2.0.3.min.js') ?>
<?= $this->Html->script('bokupan-api.js') ?>

<script>

/*
 * 利用例。
 * 非同期なので↓は全部同時には上手く動かないので注意
 */


    // 部屋を作成する
    BokupanAPI.addRoom({
        "name"      : "僕パンやろうぜ！",
        "host_user" : "makimaki-soft",
        "message"   : "初心者歓迎",
    }, function(data){
        console.log("addRoom");
        console.log(data);
    }, function(){
        console.log("fail");
    });

    // 部屋を編集する
    BokupanAPI.editRoom({
        "id"            : 1,
        "host_user_pid" : "QWERASDF",
    }, function(data){
        console.log("editRoom");
        console.log(data);
    }, function(){
        console.log("fail");
    });

    // 部屋を編集する
    BokupanAPI.deleteRoom({
        "id" : 1,
    }, function(data){
        console.log("deleteRoom");
        console.log(data);
    }, function(){
        console.log("fail");
    })

    // 部屋を一覧を取得する
    BokupanAPI.getRoomList(
    function(data){
        console.log("getRoomList");
        console.log(data);
    }, function(){
        console.log("fail");
    });
</script>