 <form class="form-horizontal" role="form" method="POST" action="{{ {{ url('password/email') }} }}">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                {{ csrf_field() }}
                                <label for="email" class="sr-only"></label>
                                <input type="email" class="form-control" name="email" id="form-email" value="{{old('email')}}" placeholder="Correo Electronico" required autofocus>
                                <input type="button" name="Enviar" value="">
                            </div>
                           </form>