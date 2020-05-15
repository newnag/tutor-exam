$(document).ready(function(){
    $('.game-zone .box:first-child').addClass('active'); // เซ็ตให้ตัวแรกมีคลาส active
    if($('#gamezone').attr('data-gamemode') === "easy"){
        $('#max-game').text($('.game-zone-ez .box').length); // เซ็ตจำนวนข้อทั้งหมดที่ต้องทำ
    }
    else if($('#gamezone').attr('data-gamemode') === "sp"){
        $('#max-game').text($('.game-zone-sp .box').length); // เซ็ตจำนวนข้อทั้งหมดที่ต้องทำ
    }
    else if($('#gamezone').attr('data-gamemode') === "rank"){
        $('#max-game').text($('.game-zone-rank .box').length); // เซ็ตจำนวนข้อทั้งหมดที่ต้องทำ
    }
    $('.mode-game button').on('click',function(){
        var mode = $(this).attr('data-mode');
        $(this).parent().hide();

        if(mode === 'rank' || mode === 'sp'){
            let url = window.location.href;
            window.location.href = url+"?mode="+mode;
        }
        else{
            $('.subject').css("display","flex");
        }   
    }); //เลือกระดับความยาก

    if($('.game-zone').is(":visible")){ // ให้วิชาหายเมื่อคำถามขึ้นแล้ว
        $('.subject').hide();
    }
});

// ------------------------------- กดปุ่มตอบคำถาม ----------------------------- //
$('.game-zone-ez .box .button-group .next-button').click(function(){
    let anwser = $(this).text();
    let correct = $(this).closest('.box').attr('data-ans');
    let count_ele = $('.game-zone-ez .box').length;
    check_anwser(this,anwser,correct,count_ele); // ค่าที่ส่งไปคือ ele,คำตอบ,คำตอบที่ถูก,จำนวนข้อที่กำหนด 
});

$('.game-zone-sp .box .button-group .next-button').click(function(){
    let anwser = $(this).text();
    let correct = $(this).closest('.box').attr('data-ans');
    let count_ele = $('.game-zone-sp .box').length;
    check_anwserSP(this,anwser,correct,count_ele); // ค่าที่ส่งไปคือ ele,คำตอบ,คำตอบที่ถูก,จำนวนข้อที่กำหนด 
});

$('.game-zone-rank .box .button-group .next-button').click(function(){
    let anwser = $(this).text();
    let correct = $(this).closest('.box').attr('data-ans');
    let count_ele = $('.game-zone-rank .box').length;
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
    $('#min-game').text(count_num_game); // เพิ่มจำนวนข้อที่ทำไปแล้ว
    nextGame(that);
    countGame(this.ele,score);
    $('.score h2').text(score);
}

// ฟังก์ชั่นกดคำตอบแบบ SP
function check_anwserSP(that,anw,corr,ele_length){
    this.anw = anw;
    this.corr = corr;
    this.ele = ele_length;
    if(this.anw === this.corr){
        swal("ยินดีด้วย!", "คุณตอบถูก", "success");
        score++;
        count_num_game++;
        $('#min-game').text(count_num_game); // เพิ่มจำนวนข้อที่ทำไปแล้ว
        nextGame(that);
        countGame(this.ele,score);
        $('.score h2').text(score);
    }
    else{
        swal("เสียใจด้วย!", "คุณตอบผิด ต้องตอบคำถามใหม่ตั้งแต่เริ่มต้น", "warning").then(function(){
            window.location.href = "/";
        });
    }
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
    this.minTime = $('#time-min').text();
    this.secTime = $('#time-sec').text();
    this.Ajax = function(){
        $.ajax({
            type:'POST',
            url: 'https://optimumpeptides.com/complate-score',
            data:   {
                        'score':this.score,
                        'min':this.minTime,
                        'sec':this.secTime
                    },
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
            },
            beforeSend:function(){
                swal("กำลังดำเนินการบันทึกข้อมูล","กรุณาอย่าปิดหน้าหรือรีเฟรชหน้าในขณะบันทึกข้อมูล","info",{button:false});
            }
        });
    };
    //console.log(count_num_game);
    // เช็คการนับจำนวน เมื่อครบจะประกาศผลและคะแนน
    if(count_num_game >= this.count){
        if(this.count == this.score){
            swal("สุดยอดคุณเก่งมาก!", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success").then(function(){
                this.Ajax();
            });
        }
        else if((this.score/this.count)*100 >= 80){
            swal("คุณเก่งมาก", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success").then(function(){
                this.Ajax();
            });
        }
        else if((this.score/this.count)*100 >= 50){
            swal("น้อยไปหน่อยคุณต้องพยามกว่านี้นะ", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success").then(function(){
                this.Ajax();
            });
        }
        else if((this.score/this.count)*100 < 50){
            swal("ไม่ผ่านคุณต้องพยายามมากกว่านี้", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success").then(function(){
                this.Ajax();
            });
        }
        else if((this.score/this.count)*100 < 20){
            swal("แย่จริงๆลิงยังทำได้มากกว่าคุณเลย", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success").then(function(){
                this.Ajax();
            });
        }
        else if((this.score/this.count)*100 == 0){
            swal("ตั้งใจหน่อยอย่าทำเป็นเล่นสิ", "คุณทำข้อสอบผ่านทั้งหมดด้วยคะแนน : "+this.score, "success").then(function(){
                this.Ajax();
            });
        } 
    }
}



// ------------------------------------------------------------------------------------------------------------------ //

// ------------------------------------------------- กดปุ่มเลือกหมวดหมู่ย่อย --------------------------------------------- //
$('.subject button').click(function(){
    let cat = $(this).attr('data-cat');
    changeCat(cat);
});

function changeCat(cat){
    this.cat = cat;
    let url = window.location.href;
    url = url+this.cat+"?mode=easy";
    //console.log(url);
    window.location.href = url;
}

// ------------------------------------------------------------------------------------------------------------------ //

// ----------------------------------- ระบบ login ------------------------------------- //
class login {
    constructor(user,pass){
        this.user = user;
        this.pass = pass;
    }

    send_login(){
        var data_login = {"user":this.user,"pass":this.pass};

        $.ajax({
            type:'POST',
            url:'https://optimumpeptides.com/verifylogin',
            data:data_login,
            success:function(data){
                //console.log(data);
                if(data === "login success"){
                    swal("เข้าสู่ระบบเรียบร้อย","กำลังทำการพาท่านกลับสู่หน้าหลัก กรุณารอสักครู่","success").then(function(){
                        window.location.href = "/";
                    });
                }
                else if(data === "false"){
                    swal("เกิดข้อผิดพลาด","ท่านใส่ชื่อผู้ใช้หรือรหัสไม่ถูกต้อง","warning");
                }
                else{
                    swal("เกิดข้อผิดพลาด","โปรดติดต่อผู้ดูแลระบบ","error");
                }
            },
            error:function(error){
                alert(error);
            }
        })
    }
}

// เรียกใช้คลาส login
$('.login-box .login-form .button button').on('click',function(){
    let user = $(this).closest('.login-form').find('.input input[name="user"]').val();
    let pass = $(this).closest('.login-form').find('.input input[name="pass"]').val();
    let callLogin = new login(user,pass);
    callLogin.send_login();
});

// ------------------------------------------------------------------------------------------------- //

// --------------------------------------- ระบบสมัครสมาชิก ------------------------------------------- //
class register{
    constructor(user,pass,conpass,email,age,educate){
        this.user = user;
        this.pass = pass;
        this.conpass = conpass;
        this.email = email;
        this.age = age;
        this.educate = educate;
    }

    getRegister(){
        var register_data = {
            "user":this.user,
            "pass":this.pass,
            "conpass":this.conpass,
            "email":this.email,
            "age":this.age,
            "educate":this.educate
        };

        $.ajax({
            type:'POST',
            url:'https://optimumpeptides.com/verifyregister/',
            data:register_data,
            dataType:'json',
            success:function(data){
                for(var key in data){
                    console.log(data[key]); 
                    if(data[key] === "success"){
                        swal("สมัครเสร็จสิ้น","ลงทะเบียนเสร็จสมบูรณ์แล้ว กด ok เพื่อกลับสู่หน้าเข้าสู่ระบบ","success").then(function(){
                            window.location.href = "/login";
                        });
                    }
                    else if(data[key] === "nodata"){
                        swal("เกิดข้อผิดพลาด","แจ้งผู้ดูแลระบบเพื่อแก้ไขปัญหา","error");
                    }
                    else{
                        swal("มีข้อผิดพลาดในการสมัคร",data[key],"warning");
                    }
                }
            },
            error:function(error){
                swal("เกิดข้อผิดพลาด","แจ้งผู้ดูแลระบบเพื่อแก้ไขปัญหา","error");
            }
        })
    }
}

// เรียกใช้คลาส register
$('.register-box .register-form .button #regis').on('click',function(){
    let user = $(this).closest('.register-form').find('.input #user').val();
    let pass = $(this).closest('.register-form').find('.input #pass').val();
    let passcon = $(this).closest('.register-form').find('.input #pass-con').val();
    let email = $(this).closest('.register-form').find('.input #email').val();
    let age = $(this).closest('.register-form').find('.input #age').val();
    let edu = $(this).closest('.register-form').find('.select select').val();

    let regisnew = new register(user,pass,passcon,email,age,edu);
    regisnew.getRegister();
})

// --------------------------------------------------------------------------------------------------------- //

// -------------------------------------------- ระบบนับเวลาสอบ ---------------------------------------------- //
if($('.game-zone-ez').is(":visible") || $('.game-zone-sp').is(":visible") || $('.game-zone-rank').is(":visible")){
    var minutesLabel = document.getElementById("time-min");
    var secondsLabel = document.getElementById("time-sec");
    var totalSeconds = 0;
    setInterval(setTime, 1000);
    
    function setTime() {
      ++totalSeconds;
      secondsLabel.innerHTML = pad(totalSeconds % 60);
      minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
    }
    
    function pad(val) {
      var valString = val + "";
      if (valString.length < 2) {
        return "0" + valString;
      } else {
        return valString;
      }
    }
}

// -------------------------------------------------------------------------------------------------------- //

// ---------------------------------------------- ปุ่มกดเมนูมือถือ -------------------------------------------- //
$('.mobile-menu #menu-mobile').on('click',function(){
    console.log(111);
    $(this).next().children().slideDown();
    $(this).next().next().show();
});
$('.close-button').on('click',function(){
    $(this).prev().children().slideUp();
    $(this).hide();
});

// ------------------------------------------- Block F12 ----------------------------------------------- //
// $(document).keydown(function (event) {
//     if (event.keyCode == 123) { // Prevent F12
//         swal("เกิดข้อผิดพลาด","เกิดข้อผิดพลาดบางอย่างจากการกระทำของคุณ","error");
//         return false;
//     } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I   
//         swal("เกิดข้อผิดพลาด","เกิดข้อผิดพลาดบางอย่างจากการกระทำของคุณ","error");     
//         return false;
//     }
// });
// $(document).on("contextmenu", function (e) { 
//     swal("เกิดข้อผิดพลาด","เกิดข้อผิดพลาดบางอย่างจากการกระทำของคุณ","error");       
//     e.preventDefault();
// });