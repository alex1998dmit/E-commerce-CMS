Здравствуйте <i>{{ $user->name  }}</i>!
<p>Вы получили это письмо, потому что зарегистрировались на сайте nadya.shop. Если вы не регистрировались на сайте не предпринимайте никаких действий</p>
<br>
<b>Чтобы подтвердить свой аккаунт  перейдите по ссылке: </b>
<br>
<a href="http://www.nady.shop/api/v1/confirm?username={{ $user->email }}&token={{ $user->verification_token }}">Подтвердить почту</a>
<br>
С уважением,
<br/>
<i>nadya.shop@support.com</i>

