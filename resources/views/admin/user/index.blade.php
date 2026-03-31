<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<h2>Vendor List</h2>

<button onclick="showUserForm()">+ Add Vendor</button>

<div id="userList"></div>

<div id="userFormArea" style="display:none;">
    <form id="userForm">
    @csrf

    <input type="hidden" id="user_id">

    <input type="text" name="name" placeholder="Name"><br><br>

    <input type="email" name="email" placeholder="Email"><br><br>

    <input type="password" name="password" placeholder="Password"><br><br>

    <label>Select Role</label><br>
    <select name="role">
        <option value="">-- Select Role --</option>
        <option value="admin">Admin</option>
        <option value="vendor">Vendor</option>
    </select>

    <br><br>

    <button type="submit">Save</button>
</form>
</div>

<script>
$.ajaxSetup({
    headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
});

function loadUsers(){
    $.get('/admin/users/list',function(data){
        let html='';
        data.forEach(u=>{
            html+=`
            <div>
                ${u.name} (${u.email}) - <b>${u.role}</b>
                <button onclick="editUser(${u.id})">Edit</button>
                <button onclick="deleteUser(${u.id})">Delete</button>
            </div>`;
        });
        $('#userList').html(html);
    });
}
loadUsers();

function showUserForm(){
    $('#userFormArea').show();
    $('#userForm')[0].reset();
    $('#user_id').val('');
}

$(document).on('submit','#userForm',function(e){
    e.preventDefault();

    let id=$('#user_id').val();
    let url=id?'/admin/users/update/'+id:'/admin/users/store';

    $.post(url,$(this).serialize(),function(res){
        loadUsers();
        $('#userFormArea').hide();
    });
});

function editUser(id){
    $.get('/admin/users/edit/'+id,function(data){
        $('#userFormArea').show();
        $('#user_id').val(data.id);
        $('input[name=name]').val(data.name);
        $('input[name=email]').val(data.email);
        $('select[name=role]').val(data.role);
    });
}

function deleteUser(id){
    if(confirm('Delete?')){
        $.ajax({
            url:'/admin/users/delete/'+id,
            type:'DELETE',
            success:function(){
                loadUsers();
            }
        });
    }
}
</script>