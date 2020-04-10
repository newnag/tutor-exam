$(document).ready(function(){
    $('.game-zone .box:first-child').addClass('active'); // เซ็ตให้ตัวแรกมีคลาส active
    $('#max-game').text($('.game-zone .box').length); // เซ็ตจำนวนข้อทั้งหมดที่ต้องทำ
    if($('.game-zone').is(":visible")){ // ให้วิชาหายเมื่อคำถามขึ้นแล้ว
        $('.subject').hide();
    }
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
    $('#min-game').text(count_num_game); // เพิ่มจำนวนข้อที่ทำไปแล้ว
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
    url = url+this.cat;
    //console.log(url);
    window.location.href = url;
}

// ------------------------------------------------------------------------------------------------------------------ //

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
if($('.game-zone').is(":visible")){
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