// clem/steam
$(document).ready(function(){
    $('#clemfeed-steamlibrary').request('onInit',{
        success:function(data){
            $('#clemfeed-steamlibrary').append(data.head);
            $('#clemfeed-steamlibrary').append(data.body);
        }
    });
    $('#clemfeed-steamlibrary').on('click',function(i,e){

        var rank = $('#clemfeed-steamlibrary').find('.list-group-item').last().attr('rank');
        console.log(rank);

        $('#clemfeed-steamlibrary').request('onAppend',{
            data: { rank: rank },
            success:function(data){
                if (data.init) {
                    $('#clemfeed-steamlibrary').empty();
                    $('#clemfeed-steamlibrary').append(data.head);
                    $('#clemfeed-steamlibrary').append(data.body);
                }else{
                    $('#clemfeed-steamlibrary').find('.list-group-item').last().after(data.item);
                }
            }
        });
    });
});
