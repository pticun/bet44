$('#myTable').tablesorter();
$(function(){

    // var c = [0, 0, 0];
    // var length = c.length;
    // var max = 4;
    //
    // while(c[c.length-1]<max ){
    //     for($i=0; $i<length; $i++){
    //         if(c[$i] === max ){
    //             if(c[$i+1] !== undefined){
    //                 c[$i+1]++;
    //             }
    //         }
    //
    //     }
    // }

    // $('#myTable').find('.row').each(function(){
    //     $(this).find('td').each(function(){
    //         var $this = $(this);
    //         setTimeout(function(){
    //             $('.row').css({backgroundColor: '#fff', color: '#000'});
    //             $this.css({backgroundColor: '#000', color: '#fff'});
    //         }, 1000)
    //         // $('.row').css({backgroundColor: '#fff', color: '#000'});
    //     })
    // });

    function cell_styles(counter, elements){ //console.log('here');
        console.log(counter);
        // $(elements).css({background: '#fff', color: '#000'});
        $(elements).find('td').css({background: '#fff', color: '#000'});
        var number_of_rows = counter.length;
        for ($i=0; $i<number_of_rows; $i++){
            $(elements[$i]).eq(0).find('td').eq(counter[$i]).css({background: '#000', color: '#fff'});
            // $(elements[$i]).eq($i).eq(counter[$i]).css({background: '#000', color: '#fff'})
        }
    }

    function add_result_set(counter, elements){
        var number_of_rows = counter.length;
        for ($i=0; $i<number_of_rows; $i++){
            var result = [];
            var text = $(elements[$i]).eq(0).find('td').eq(counter[$i]).text();
            result.push(text);
            // $(elements[$i]).eq($i).eq(counter[$i]).css({background: '#000', color: '#fff'})
        }

        results.push(result);
    }

    //
    // cell_styles([0,1,0], $('.row'));
    // return;

    function iterate(counter, index){
        if(counter[index] === row_length-1){
            if(counter[index+1] !== undefined){
                counter[index] = 0;
                iterate(counter, index+1);
            }
        } else {
            counter[index]++;
        }
    }

    var rows = $('#myTable').find('.row');
    var rows_count = rows.length;
    var row_length = $(rows).eq(0).children().length;
    var results = [];

    var counter = [];
    for($i=0; $i<rows_count; $i++){
        counter.push(0);
    }

    var stopper = 0;
    function iterate_me(counter){

        counter[0] = 0;
        for($i=0; $i<row_length; $i++){
            console.log(counter);


            var number_of_rows = counter.length;
            for ($i=0; $i<number_of_rows; $i++){
                var result = [];
                var text = $(rows[$i]).eq(0).find('td').eq(counter[$i]).text();
                result.push(text);
                // $(elements[$i]).eq($i).eq(counter[$i]).css({background: '#000', color: '#fff'})
            }

            results.push(result);


            counter[0]++;
            stopper++
            if(stopper >= 500){
                console.log('limit reached');
                return;
            }
        }

        // if(counter[counter.length-1] === row_length-1){
        //     console.log(counter);
        //     console.log('finished');
        //     return;
        // }

        iterate(counter, 1);

        iterate_me(counter);
    }

    iterate_me(counter);
console.log(results);
    return;
    // while(counter[counter.length-1] <= row_length){
    //     iterate_me(counter[0]);
    // }
    var $ri=0;
    var $i=0;
    var interval = setInterval(function(){
        var row = $(rows[$ri]).find('td');
        if(row[$i-1] !== null){
            $(row[$i-1]).css({background: '#fff', color: '#000'});
        }
        $(row[$i]).css({background: '#000', color: '#fff'});
        $i++;

        if($i === row.length){
            $ri++;
            $i = 0;
        }
        // if($i === rows.length){
        //     clearTimeout(interval);
        // }
    }, 500)

});


