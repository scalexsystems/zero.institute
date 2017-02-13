<form action="/request" method="post" class="invite-form">
  {!! csrf_field() !!}

  <div class="row">
    <div class="col-12 col-md-4 offset-md-1">
      <div class="form-group">
        <input class="form-control" type="text" placeholder="Name of the institute" name="name" required minlength="1">
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="form-group">
        <input class="form-control" type="email" placeholder="Contact email address" name="email" required>
      </div>
    </div>
    <div class="col-12 col-md-2">
      <div class="form-group">
        <button class="btn btn-primary btn-block" type="submit">Get invited!</button>
      </div>
    </div>
  </div>
</form>
