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
    this.Ajax = function(){
        $.ajax({
            type:'POST',
            url: 'https://optimumpeptides.com/complate-score',
            data: {'score':this.score},
            success: function(data){
                if(data === "Update Success"){
                    swal("บันทึกสำเร็จ","ระบบทำการบันทึกคะแนนสำเร็จแล้วและจะพาคุณไปสู่หน้าหลัก","success").then(function(){
                        window.location.href = "/";
                    });
                }
                else if(data === "Dont Login"){
                    swal("เกิดข้อผิดพลาด","คุณยังไม่ได้ทำการเข้าสู่ระบบ คะแนนจะไม่ทำการบันทึกผล","warning");
                }
                else{
                    swal("เกิดข้อผิดพลาด","มีปัญหาเกี่ยวกับระบบ กรุณาติดต่อผู้ดูแล","error")
                }
            }
        });
    };
    //console.log(count_num_game);
    // เช็คการนับจำนวน เมื่อครบจะประกาศผลและคะแนน
    if(count_num_game >= this.count){
        if(this.count == this.score){
            swal("สุดยอดเลย!", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success").then(function(){
                this.Ajax();
            });
        }
        else{
            swal("คุณทำข้อสอบหมดแล้ว!", "คุณได้คะแนนทั้งหมด : "+this.score, "success").then(function(){
                this.Ajax();
            });
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