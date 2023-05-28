<html lung="ru">
	<head>
	<link rel="stylesheet" href="index2.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body><div class="con">
<form action="index.php"
	      method ="POST"><div>
		       <label>
			   <div> имя</div>       <input name ="fio" id="fio1"
					   placeholder="ваше имя" />
							 </label>
		       <label>
</div>
<div>		       
<div>год</div> 
		       <input name ="year" type="date" id="date1"
					   placeholder="год вашего рождения" />
							 </label>
</div>	       
<div>
			   <label>
			   <div>  email</div>
		       <input name ="email"
					   placeholder="ваша почта" id="email1"/>
							 </label></div>
							 <div>
			   <label> <div>биография</div>
			
			<textarea name="biography"id="biography2"></textarea>
			</label></div>
		<div>
		<div>кол-во конечностей</div>       
			<div class="limb">
			<label>		
				
			<input name ="limbs" type="radio" checked="checked"
					   value="2limbs" /> <div>2</div>
					        </label>
	<label>		       
		    
		       <input name ="limbs" type="radio" checked="checked"
					   value="4limbs" /> <div>4</div>
					        </label>					
		<label>		       
		    
		       <input name ="limbs" type="radio" checked="checked"
					   value="10limbs" /> <div>10</div>
					        </label>
				
			</div></div>
							<div>			<div>пол</div>
							<div class="gen">
							<label>
		       <input name ="gender" type="radio" checked="checked"
					   value="man" /> <div>мужской</div> </label>
		       <label> 
	               <input name ="gender" type="radio" checked="checked"
					   value="woman" /><div> женский </div></label>
					           </div>
							   </div> 
							   <div> <select name ="Abilities[]"  multiple>
				<option value="1">левитация</option>
				<option value="2">бессмертие</option>
				<option value="3">невидимость</option>
		</select>
</div>
<div><input name ="box" type="checkbox" id="box" checked="checked"/> с контрактом ознакомлен(а)
					        </label> </div>
             		<button type="submit" class="btn">Отправить</button>
             </form></div>
			 <script>
				$('#box').on('change', function(){
  if($(this).is(':checked')) $('.btn').attr('disabled', false);
  else $('.btn').attr('disabled', true);
});
</script>
 </body>
</html>