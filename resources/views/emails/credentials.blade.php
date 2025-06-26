<p>Hello,</p>

<p>Your account has been created. Here are your login credentials:</p>

<ul>
    <li><strong>Email:</strong> {{ $email }}</li>
    <li><strong>Password:</strong> {{ $password }}</li>
</ul>

<p>Please change your password after your first login.</p>

<p>Thanks,<br>
    {{ config('app.name') }}</p>
