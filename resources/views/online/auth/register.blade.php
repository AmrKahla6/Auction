@extends('layouts.online.visitor')
@section('content')
		<div class="page-title">
			<div class="container">
				<div class="head-title">
					<h3>انشاء حساب جديد</h3>
					<p>إذا كان لديك حساب معنا ، الرجاء الدخول إلى صفحة تسجيل الدخول.</p>
				</div>
			</div>
		</div>
		<div id="login-content">
			<div class="content">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#person">حساب عادي</a></li>
				<li><a data-toggle="tab" href="#facility">حساب تجاري</a></li>
			</ul>
			<div class="tab-content">
				<div id="person" class="tab-pane fade in active">
					<div class="login-box">
						<form action="{{route('live.register')}}" method="post">
							@csrf
							@method('post')
							<div class="form-group">
								<input type="text" required="required" name="username" value="" placeholder="اسم المستخدم" id="input-username" class="form-control">
							</div>
							<div class="form-group">
								<input type="tel"  required="required"  name="phone" value="" placeholder="رقم الهاتف" id="input-phone" class="form-control">
							</div>
							<div class="form-group">
								<input type="date"  required="required" name="date_of_birth" value="" placeholder="تاريخ الميلاد" id="input-date" class="form-control">
							</div>
							<div class="form-group">
								<input type="text" name="nationality" value="" placeholder="الجنسية" id="input-nationality" class="form-control">
							</div>
							<div class="form-group">
								<input type="text"  required="required" name="email" value="" placeholder="البريد الإلكتروني" id="input-email" class="form-control">
							</div>
							<div class="form-group">
								<input type="password"  required="required" name="password" value="" placeholder="كلمة المرور" id="input-password" class="form-control">
							</div>
							<input type="hidden" name="type" value="0">
							<div class="login-box-footer">
								<button type="submit"  class="btn btn-block btn-lg btn-primary">تسجيل</button>
								<div class="text-hr"><span>أو</span></div>
								<p><a href="{{route('live.login')}}" class="link-register">تسجيل الدخول</a></p>
							</div>
						</form>
					</div>
				</div>
				<div id="facility" class="tab-pane fade">
					<div class="login-box">
						<form action="{{route('live.register')}}" method="post" >
							@csrf
							@method('post')
							<div class="form-group">
								<input type="text"  required="required" name="username" value="" placeholder="اسم المستخدم" id="input-username" class="form-control">
							</div>
							<div class="form-group">
								<input type="number"  required="required" name="commercial_record" value="" placeholder="السجل التجاري" id="input-commercial_record" class="form-control">
							</div>
							<div class="form-group">
								<input type="tel"  required="required" name="phone" value="" placeholder="رقم الهاتف" id="input-phone" class="form-control">
							</div>
							<div class="form-group">
								<input type="text"  required="required" name="date_of_birth" value="" placeholder="تاريخ الميلاد" id="input-date" class="form-control">
							</div>
							<div class="form-group">
								<input type="number"  required="required" name="id_number" value="" placeholder="رقم الهوية" id="input-identity_number" class="form-control">
							</div>
							<div class="form-group">
								<input type="text" name="email" value="" placeholder="البريد الإلكتروني" id="input-email" class="form-control">
							</div>
							<div class="form-group">
								<input type="password"  required="required" name="password" value="" placeholder="كلمة المرور" id="input-password" class="form-control">
							</div>
							<input type="hidden" name="type" value="1">
							<div class="login-box-footer">
								<button type="submit" class="btn btn-block btn-lg btn-primary">تسجيل</button>
								<div class="text-hr"><span>أو</span></div>
								<p><a href="{{route('live.login')}}" class="link-register">تسجيل الدخول</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>

				
			</div>
		</div>
		
 @endsection