/* jquery.js */

var api_list = 'http://localhost/myweb/db2_api/api/read.php';
var api_disp = 'http://localhost/myweb/db2_api/api/read_one.php';
var api_find = 'http://localhost/myweb/db2_api/api/read_find.php';



$('#btn_list').click(function(){
    $('#tablelist').empty();
    $('#showarea').html('');
    $('#message').html('Loading...');
    $.ajax({
        dataType: "json",
        url: api_list,
        success: function(data){
        
            var ary = data.records;     // 須依據資料內容修改
            var total_rec = data.total_rec;

            console.log(ary[0]);
            $('#message').html('資料已成功讀取 ' + total_rec + ' 筆記錄');
            $('#showarea').html(JSON.stringify(ary[0]));
            func_show(ary);
        },
        error: function(){ 
            $('#message').html('資料讀取發生錯誤');
        },
    }); // end of ajax()
}); // end of click()




$('#btn_disp').click(function() {
    $('#tablelist').empty();
    $('#showarea').html('');
    $('#message').html('Loading...');
    $.ajax({
        type: "GET",
        data: {
            uid: $('#uid').val(),
        },
        dataType: "json",
        url: api_disp,
        success: function(data){

            var ary = data.records;     // 須依據資料內容修改
            var total_rec = data.total_rec;

            console.log(ary[0]);
            $('#message').html('資料已成功讀取 ' + total_rec + ' 筆記錄');
            $('#showarea').html(JSON.stringify(ary[0]));
            func_show(ary);
        },
        error: function(){ 
            $('#message').html('資料讀取發生錯誤');
        },
  }); // end of ajax()
}); // end of click()



$('#btn_find').click(function(){
    $('#tablelist').empty();
    $('#showarea').html('');
    $('#message').html('Loading...');
    $.ajax({
        type: "GET",
        data: {
            key: $('#key').val(),
        },
        dataType: "json",
        url: api_find,
        success: function(data){
        
            var ary = data.records;     // 須依據資料內容修改
            var total_rec = data.total_rec;

            //console.log(ary[0]);
            $('#message').html('資料已成功讀取 ' + total_rec + ' 筆記錄');
            $('#showarea').html(JSON.stringify(ary[0]));
            func_show(ary);
        },
        error: function(){ 
            $('#message').html('資料讀取發生錯誤');
        },
    }); // end of ajax()
}); // end of click()



var func_show = function(ary){
    var items = [];
    $.each(ary, function(i, item){
        
        // 取得各欄位的資料
        var str = '';
        str += '<td>' + item.usercode + '</td>';
        str += '<td>' + item.username  + '</td>';
        str += '<td>' + item.address + '</td>';
        str += '<td>' + item.birthday + '</td>';
        str += '<td>' + item.height + '</td>';
        str += '<td>' + item.weight + '</td>';
        str += '<td>' + item.remark + '</td>';
        
        items.push('<tr>'+str+'</tr>');
    }); // end of each()
    
    $('#tablelist').append( items.join('') );
};
