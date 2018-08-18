
<?php
	require('restclient.php');
	$restApi = new RestClient();
	if(isset($_REQUEST['method']) && $_REQUEST['method']=="send_voucher"){
		$insertResult = $restApi->post('send_voucher_code', $_REQUEST);
		$insertResponse = json_decode($insertResult->response, true);
		echo $insertResponse['result'];
		exit;
	}
	$restResult = $restApi->get('vouchers_list', array());
	//echo '<pre>';
	//print_r($restResult);
	$results = json_decode($restResult->response, true);
	//print_r($results);
	//echo '</pre>';
	//die;
	//$restResult = $restApi->post('create_voucher_code', array());
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script> -->
	<link rel="stylesheet" href="style.css" type="text/css">
	<style>
		.panel {
		border-color: #337ab7;
	}
		
	</style>
	<script>
		function populate(voucher_id){
			$("#id").val(voucher_id);
			$("#code").val($("#code_"+voucher_id).val());
			return false;
		}
		
		$(document).ready(function(){
			$("#send_code").click(function(){
				var id = $("#id").val();
				var code = $("#code").val();
				var offer_id = $("#offer_id").val();
				var user_email = $("#user_email").val();
				if(id == ''){
					alert("Please Select Voucher Code");
					return false;
				}
				if(offer_id == ''){
					alert("Please Select Offer");
					return false;
				}
				if(user_email.length==0){
					alert("Please Enter Email");
					return false;
				}
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if(!regex.test(user_email)){
					alert("Please Enter Valid Email");
					return false;
				}
				$.ajax({
					type: "POST",
					url: "index.php",
					data : {
						method: "send_voucher",
						id: id,
						code : code,
						offer_id : offer_id,
						user_email : user_email
					},
					async : false,
					success: function(html){
						if($.trim(html)=='success'){	
							alert("Voucher Code Sent Successfully");
							location.reload();
						} else{
							alert("Some Thing went wrong please try again later");
							return false;
						}
					},
					error: function(){
						alert("ajax error");
					}
				});
			});
			
			$("#reset").click(function(){
				$("#id").val('');
				$("#code").val('');
				$("#offer_id").val('');
				$("#user_email").val('');
			});
		});
	</script>
</head>
<body>
	<div id="wrap">
		<div class="container">
		<h3>Voucher Pool Application</h3>
			<div class="panel panel-default" style="margin-top: 10px; margin-right: 10px; margin-bottom: 10px;">
			<div class="panel-body">
				<div class="table-responsive" >
					<div>
						<table>
							<tr>
								<td>
									<label>Voucher Coder : </label>
									<input type="text" id="code" disabled value="">
									<input type="hidden" id="id" value="">
								</td>
								<td>
									<label>Select Offer : </label>
									<?php
										$offerResult = $restApi->get('offers_list', array());
										$offers = json_decode($offerResult->response, true);
									?>
									<select name="offer_id" id="offer_id">
									<option value="">--Select--</option>
									<?php
									if(!empty($offers)){
										foreach($offers as $offer){
											echo '<option value="'.$offer['offer_id'].'">'.$offer['percentage'].'</option>';
										}
									}
									?>
									</select>
								</td>
								<td>
									<label>Email : </label>
									<input type="text" id="user_email" value="">
								</td>
								<td>
									<input type="button" value="Send Code" id="send_code" style="cursor: pointer;">
									<input type="button" value="Reset" id="reset" style="cursor: pointer;">
								</td>
							</tr>
						</table>
					</div>
					<table width='70%' class="table table-striped table-bordered" id='rep_grid_display'  >
						<thead>
							<tr>
								<th bgcolor="#337ab7" ><span style="color: #FFF;">Voucher Code</span></th>
								<th bgcolor="#337ab7" ><span style="color: #FFF;"></span></th>
								<th bgcolor="#337ab7" ><span style="color: #FFF;">Offer</span></th>
								<th bgcolor="#337ab7" ><span style="color: #FFF;">Email</span></th>
								<th bgcolor="#337ab7" ><span style="color: #FFF;">Is Used</span></th>
								<th bgcolor="#337ab7" ><span style="color: #FFF;">Expired At</span></th>
								<th bgcolor="#337ab7" ><span style="color: #FFF;">Date Used</span></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($results as $result){
								echo "<tr>";
									echo "<td><input type='hidden' id='code_".$result['id']."' value='".$result['code']."'>".$result['code']."</td>";
									echo "<td width='25'>"; if($result['user_email']==""){ echo "<img style='cursor: pointer;' src='settings.png' width='15' height='15' onclick='populate(".$result['id'].")'>"; } echo "</td>";
									echo "<td>".$result['percentage']."</td>";
									echo "<td>".$result['user_email']."</td>";
									echo "<td>".$result['is_used']."</td>";
									echo "<td>".$result['expired_at']."</td>";
									echo "<td>".$result['date_used']."</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

