$(document).ready(function(){
    $('.game-zone .box:first-child').addClass('active');
});

// ------------------------------- กดปุ่มตอบคำถาม ----------------------------- //
$('.game-zone .box .button-group .next-button').click(function(){
    let anwser = $(this).text();
    let correct = $(this).closest('.box').attr('data-ans');
    let count_ele = $('.game-zone .box').length;
    check_anwser(this,anwser,correct,count_ele); // ค่าที่ส่งไปคือ ele,คำตอบ,คำตอบที่ถูก,จำนวนข้อที่กำหนด
    
});

var score = 0; // ตัวแปรนับคะแนน
var count_num_game = 0; // ตัวแปรนับข้อสอบ

// ฟังก์ชั่นใช้ในการกดคำตอบ
function check_anwser(that,anw,corr,ele_length){
    this.anw = anw;
    this.corr = corr;
    this.ele = ele_length;
    if(this.anw === this.corr){
        swal("ยินดีด้วย!", "คุณตอบถูก", "success");
        score++;
    }
    else{
        swal("เสียใจด้วย!", "คุณตอบผิด", "warning");
    }

    count_num_game++;
    nextGame(that);
    countGame(this.ele,score);
    $('.score h2').text(score);
}

// // ฟังก์ชั่นเลื่อนคำถามถัดไป
function nextGame(that){
    this.that = that;
    $(this.that).closest('.box').next().css('display','flex');
    $(this.that).closest('.box').next().addClass('active');
    $(this.that).closest('.box').css('display','none');
    $(this.that).closest('.box').removeClass('active');
}

// ฟังก์ชั่นนับจำนวนข้อ
function countGame(count,score){
    this.count = count;
    this.score = score;
    console.log(count_num_game);
    // เช็คการนับจำนวน เมื่อครบจะประกาศผลและคะแนน
    if(count_num_game >= this.count){
        if(this.count == this.score){
            swal("สุดยอดเลย!", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success");
        }
        else{
            swal("คุณทำข้อสอบหมดแล้ว!", "คุณได้คะแนนทั้งหมด : "+this.score, "success");
        }
        
    }
}

// ------------------------------------------------------------------------------ //

// ---------------------------- กดปุ่มเลือกหมวดหมู่ย่อย ----------------------------- //
$('.subject button').click(function(){
    let cat = $(this).attr('data-cat');
    changeCat(cat);
});

function changeCat(cat){
    this.cat = cat;
    let url = window.location.href;
    url = url+this.cat;
    console.log(url);
    window.location.href = url;
}

// ------------------------------------------------------------------------------ //

// ---------------------------------- ตัวช่วย ------------------------------------- //

// เฉลยคำตอบ
$('#cheat-ans').on('click',function(){
    let show_ans = $('.game-zone .box.active');
    showAnwser(show_ans);
});

function showAnwser(ele){
    this.ele =ele;
    let preques = $(this.ele).attr('data-ans');
    let preAns = $(this.ele).find('.button-group button');

    for(i=0;i<=preAns.length;i++){
        if($(preAns[i]).text() === preques){
            $(preAns[i]).addClass('cheat');
        }
    }
}

// ตัดข้อทิ้ง
$('#cut-ans').on('click',function(){
    let cut_ans = $('.game-zone .box.active');
    cutAnwser(cut_ans);
});

function cutAnwser(ele){
    this.ele = ele;
    let preques = $(this.ele).attr('data-ans');
    let preAns = $(this.ele).find('.button-group button');

    for(i=0;i<=preAns.length;i++){
        if($(preAns[i]).text() !== preques){
            $(preAns[i]).addClass('cut');
            //console.log(preAns[i]);
            
        }
    }

    let ele_cut = $(this.ele).find('.cut');
    console.log(ele_cut);
    let min = 0;
    let max = 2;
    let ran = Math.floor((Math.random() * (max - min + 1)) + min);
    $(ele_cut[ran]).text('');
}