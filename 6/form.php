<html lung="ru">
	<head>
	<link rel="stylesheet" href="index2.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<style>
.err {
  background: red;
}
    </style>
</head>

<body>
<div class="con">
<form action="index.php"
	      method ="POST"><div>
		       <label >
			   <div> имя</div>       <input name ="fio"<?php  if(!empty($_COOKIE['err_fio'])||!empty($_COOKIE['err_fio2'])) {print 'class="err"';} ?> value="<?php if(!empty($_SESSION["fio"])) {echo $_SESSION["fio"];}?>" id="fio1"
					   placeholder="ваше имя" />
							 </label><div >	<?php if(!empty($_COOKIE['err_fio'])) {echo "Заполните имя."; setcookie("err_fio","");} else{echo '';}?></div><div >	<?php if(!empty($_COOKIE['err_fio2'])) {echo "имя пишите только латинскими буквами или только на кириллице";setcookie("err_fio2",""); } else{echo '';}?></div>
		       <label>
</div>
<div>		       
<div>год</div> 
		       <input name ="year" <?php  if(!empty($_COOKIE['err_date'])) {print 'class="err"';setcookie("err_date","");} ?>  value="<?php 
			   if(!empty($_SESSION["year"])) {echo $_SESSION["year"];}?>" type="date" id="date1"
					   placeholder="год вашего рождения" />
							 </label><div >	<?php if(!empty($_COOKIE['err_date'])) {echo "Заполните год."; } else{echo '';}?></div>
</div>	       
<div>
			   <label>
			   <div>  email</div>
		       <input name ="email" <?php  if(!empty($_COOKIE['err_email'])||!empty($_COOKIE['err_email2'])) {print 'class="err"';} ?> 
					   placeholder="ваша почта"value="<?php if(!empty($_SESSION["email"])) {echo $_SESSION["email"];}?>" id="email1"/>
							 </label><div >	<?php if(!empty($_COOKIE['err_email'])) {echo "Заполните почту."; setcookie("err_email","");} else{echo '';}?></div><div >	<?php if(!empty($_COOKIE['err_email2'])) {echo "отсутствует символ '@'"; setcookie("err_email2","");} else{echo '';}?></div>
							</div>
							 <div>
			   <label> <div>биография</div>
			
			<textarea name="biography" <?php if(!empty($_COOKIE['err_biography'])) {print 'class="err"'; setcookie("err_biography","");} ?>  id="biography2"><?php  if(!empty($_SESSION["biography"])) {echo $_SESSION["biography"];}?></textarea>
			</label><div >	<?php if(!empty($_COOKIE['err_biography'])) {echo "Заполните биографию."; } else{echo '';}?></div>
		</div>
		<div>
		<div>кол-во конечностей</div>       
			<div class="limb">
			<label>		
				
			<input name ="limbs" type="radio" checked="checked"
					   value="2limbs" /> <div>2</div>
					         
		    
		       <input name ="limbs" type="radio" id="radio1" <?php if(!empty($_SESSION["limbs"])){if ($_SESSION['limbs'] == '4limbs') {echo  ' checked="checked"';}}?>
					   value="4limbs" /> <div>4</div>
					        		       
		    
		       <input name ="limbs" type="radio" id="radio2" <?php if(!empty($_SESSION["limbs"])){if ($_SESSION['limbs'] == '10limbs') {echo  ' checked="checked"';}}?>
					   value="10limbs" /> <div>10</div>
					        </label>
				
			</div></div>
							<div>			<div>пол</div>
							<div class="gen">
							<label>
		       <input name ="gender" type="radio" checked="checked" <?php if(!empty($_SESSION["gender"])){if ($_SESSION['gender'] == 'man') {echo  ' checked="checked"';}}?>
					   value="man" /> <div>мужской</div> </label>
		       <label> 
	               <input name ="gender" type="radio" <?php if(!empty($_SESSION["gender"])){if ($_SESSION['gender'] == 'woman') {echo  ' checked="checked"';}}?>
					   value="woman" /><div> женский </div></label>
					           </div>
							   </div> 
							   <div> <select  <?php  if(!empty($_COOKIE['err_abil'])) {print 'class="err"'; } ?>  name ="Abilities[]"  multiple>
				<option value="1"  <?php  if(!empty($_SESSION['err_abil'])) {print 'class="err"';} ?>  <?php if (isset($_SESSION['abil1'])&&in_array(1,unserialize($_SESSION['abil1']))) {echo  ' selected="selected"';}?>>левитация</option>
				<option value="2" <?php  if(!empty($_SESSION['err_abil'])) {print 'class="err"';} ?>   <?php if (isset($_SESSION['abil1'])&&in_array(2,unserialize($_SESSION['abil1']))) {echo  ' selected="selected"';}?>>бессмертие</option>
				<option value="3"<?php  if(!empty($_SESSION['err_abil'])) {print 'class="err"'; } ?>    <?php if (isset($_SESSION['abil1'])&&in_array(3,unserialize($_SESSION['abil1']))) {echo  ' selected="selected"';}?>>невидимость</option>
		</select><?php setcookie("err_abil","");?>
</div>
<div><input name ="box" type="checkbox" id="box" checked="checked"/> с контрактом ознакомлен(а)
					        </label> </div>
             		<button type="submit" class="btn">Отправить</button>
					 <a class="mmm" href="login.php">Авторизироваться</a>
					 <a class="mmm" href="admin.php">Вход администратора</a>
					 <a class="mmm" href="logout.php">Завершить сессию</a>


             </form></div>
			 <script>
				$('#box').on('change', function(){
  if($(this).is(':checked')) $('.btn').attr('disabled', false);
  else $('.btn').attr('disabled', true);
});
</script>
 </body>
</html>