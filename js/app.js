$('.game-zone .box .button-group .next-button').click(function(){
    let anwser = $(this).text();
    let correct = $(this).closest('.box').attr('data-ans');
    // $(this).parent().next().css('display','flex');
    // $(this).parent().hide();
    check_anwser(this,anwser,correct);
});

// ตัวแปรนับคะแนน
var score = 0;
// ฟังก์ชั่นใช้ในการกดคำตอบ
function check_anwser(that,anw,corr){
    this.anw = anw;
    this.corr = corr
    if(this.anw === this.corr){
        //console.log('Correct!');
        swal("ยินดีด้วย!", "คุณตอบถูก", "success");
        score++;
    }
    else{
        //console.log('False');
        swal("เสียใจด้วย!", "คุณตอบผิด โปรดเลือกตอบใหม่อีกครั้ง", "warning");
    }

    $('.score h2').text(score);
}