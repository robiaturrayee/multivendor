<form method="POST" action="/admin/menus/store">
@csrf

<input type="text" name="title" placeholder="Menu Title">
<input type="text" name="route" placeholder="Route">

<button type="submit">Save</button>
</form>