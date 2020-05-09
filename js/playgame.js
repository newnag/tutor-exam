$('.game-start #gamestart').on('click',function(){
  $('.edu-level').show();
  $(this).hide();
});

///////////////////////////////////////// ข้อความแจ้งเตือนแสดงก่อนเข้าเล่นแรงค์กิ้ง /////////////////////////////////////////////
if($('#notlogin').is(":visible")){
  swal("คุณไม่ได้เข้าสู่ระบบ!","คุณยังไม่ได้เข้าสู่ระบบ กรุณาเข้าสู่ระบบก่อนเลือกเล่นแรงค์กิ้ง","warning").then(function(){
    window.location.href = "/";
  })
}
if($('#rankpoint0').is(":visible")){
  swal("แต้มแรงค์กิ้งหมดแล้ว!","แต้มแรงค์กิ้งของคุณหมดแล้ว กรุณาเข้าในวันถัดไป","warning").then(function(){
    window.location.href = "/";
  })
}