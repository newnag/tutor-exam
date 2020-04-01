// ------------------------------- กดปุ่มตอบคำถาม ----------------------------- //
$('.game-zone .box .button-group .next-button').click(function(){
    let anwser = $(this).text();
    let correct = $(this).closest('.box').attr('data-ans');
    //console.log(correct);
    check_anwser(this,anwser,correct);
    
});

var score = 0; // ตัวแปรนับคะแนน
var count_num_game = 0; // ตัวแปรนับข้อสอบ

// ฟังก์ชั่นใช้ในการกดคำตอบ
function check_anwser(that,anw,corr){
    this.anw = anw;
    this.corr = corr
    //console.log(this.corr);
    if(this.anw === this.corr){
        //console.log('Correct!');
        swal("ยินดีด้วย!", "คุณตอบถูก", "success");
        score++;
        count_num_game++;
        nextGame(that);
        countGame();
    }
    else{
        //console.log('False');
        swal("เสียใจด้วย!", "คุณตอบผิด โปรดเลือกตอบใหม่อีกครั้ง", "warning");
    }

    $('.score h2').text(score);
}

// // ฟังก์ชั่นเลื่อนคำถามถัดไป
function nextGame(that){
    this.that = that;
    //console.log(this.that);
    $(this.that).closest('.box').next().css('display','flex');
    $(this.that).closest('.box').css('display','none');
    
}

// ฟังก์ชั่นนับจำนวนข้อ
function countGame(){
    console.log(count_num_game);
    if(count_num_game >= 8){
        swal("ยินดีด้วย!", "คุณทำข้อสอบผ่านทั้งหมด", "success");
    }
}

// ------------------------------------------------------------------------- //
