<form action="/upload_image" method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="submit" value="submit">
</form>