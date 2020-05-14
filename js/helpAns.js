// ------------------------------------------------------ ตัวช่วย ----------------------------------------------------- //
var check_total_help = [1,3]; // จำนวนเต็มในการใช้งานตัวช่วย

// เฉลยคำตอบ
$('#cheat-ans').on('click',function(){
    let show_ans = $('.game-zone .box.active');
    showAnwser(show_ans,check_total_help[0],this);
});
function showAnwser(ele,num_help,that){
    this.ele =ele;
    let preques = $(this.ele).attr('data-ans');
    let preAns = $(this.ele).find('.button-group button');

    // เช็คการนับจำนวน
    check_help.number(num_help);
    check_help.use();
    check_help.check(that);

    // จำนวนตัวช่วยเหลือมากกว่า 1 จะทำงานในส่วนนี้
    if(check_total_help[0] > 0){
        for(i=0;i<=preAns.length;i++){
            if($(preAns[i]).text() === preques){
                $(preAns[i]).addClass('cheat');
            }
        }
        check_total_help[0] = check_total_help[0]-1; // ลบจำนวนการใช้งานตัวช่วย
    }
}

// ตัดข้อทิ้ง
$('#cut-ans').on('click',function(){
    let cut_ans = $('.game-zone .box.active');
    cutAnwser(cut_ans,check_total_help[1],this);
});
function cutAnwser(ele,num_help,that){
    this.ele = ele;
    let preques = $(this.ele).attr('data-ans');
    let preAns = $(this.ele).find('.button-group button');

    // เช็คการนับจำนวน
    check_help.number(num_help);
    check_help.use();
    check_help.check(that);

    // จำนวนตัวช่วยเหลือมากกว่า 1 จะทำงานในส่วนนี้
    if(check_total_help[1] > 0){
        for(i=0;i<=preAns.length;i++){
            if($(preAns[i]).text() !== preques){
                $(preAns[i]).addClass('cut');
            }
        }
        check_total_help[1] = check_total_help[1]-1; // ลบจำนวนการใช้งานตัวช่วย
    }

    let ele_cut = $(this.ele).find('.cut');
    let min = 0;
    let max = 2;
    let ran = Math.floor((Math.random() * (max - min + 1)) + min);
    $(ele_cut[ran]).text('');  
}

// ตรวจเช็คจำนวนตัวช่วย
var check_help = {
    number: function(number){
        this.num = number;
    },
    use: function(){
        this.num -=  1; // ใช้ตัวช่วย
    },
    check : function(ele){ //เช็คจำนวนที่เหลือ
        this.ele = ele;
        if(this.num <= 0){
            $(this.ele).addClass('null');
            swal("ตัวช่วยหมดแล้ว", "คุณได้ใช้ตัวช่วยหมดแล้ว", "warning");
        }
    }
}

// ------------------------------------------------------------------------------------ //
