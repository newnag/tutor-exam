<?php /*Template Name: register */ ?>
<?php get_header(); ?>

<section>
    <div class="register-box">
        <div class="register-form">
            <div class="head-text"><h1>สมัครสมาชิก</h1></div>
            <div class="input">
                <input type="text" id="user" name="user" placeholder="กรุณากรอกชื่อผู้ใช้งาน">
                <input type="password" id="pass" name="pass" placeholder="กรุณากรอกรหัสผ่าน">
                <input type="password" id="pass-con" name="pass-con" placeholder="กรุณากรอกรหัสผ่านอีกครั้ง">
                <input type="email" id="email" name="email" placeholder="กรุณากรอกอีเมล์">
                <input type="tel" id="age" name="age" maxlength="2" placeholder="กรุณากรอกอายุ">
            </div>
            <div class="select">
                <select name="educate" id="">
                    <option value="">โปรดเลือกระดับการศึกษา</option>
                    <option value="ประถมต้น">ประถมต้น</option>
                    <option value="ประถมปลาย">ประถมปลาย</option>
                    <option value="มัถยมต้น">มัถยมต้น</option>
                    <option value="มัถยมปลาย">มัถยมปลาย</option>
                    <option value="ปวช">ปวช.</option>
                    <option value="มหาวิทยาลัย">มหาวิทยาลัย</option>
                </select>
            </div>
            <div class="button">
                <button id="regis">สมัครสมาชิก</button>
                <button id="reset">ล้างข้อมูล</button>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>