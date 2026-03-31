<form method="POST" action="{{ url('/admin/users/store') }}">
    @csrf

    <input type="text" name="name" placeholder="Name" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <button type="submit">Create Vendor</button>
</form>