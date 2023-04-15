<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_Message&mode={{mode}}&id={{id}}"
        method="POST"
        class="col-6 col-3-offset"
    >
        <section class="row">
        <label for="id" class="col-4">Id Mensaje</label>
        <input type="hidden" id="id" name="id" value="{{id}}"/>
        <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
        <input type="hidden" name="xssToken" value="{{xssToken}}">
        <input type="text" readonly name="iddummy" value="{{id}}"/>
        </section>

         <section class="row">
        <label for="user_id" class="col-4">Usuario Id</label>
        <input type="number" {{readonly}} name="user_id" value="{{user_id}}" maxlength="45" placeholder="Id de Usuario"/>
        </section>

        <section class="row">
        <label for="namem" class="col-4">Nombre</label>
        <input type="text" {{readonly}} name="namem" value="{{namem}}" maxlength="45" placeholder="Nombre de Usuario"/>
        </section>

        <section class="row">
        <label for="email" class="col-4">Correo</label>
        <input type="mail" {{readonly}} name="email" value="{{email}}" maxlength="100" placeholder="Correo del Usuario"/>
        </section>

        <section class="row">
        <label for="cel" class="col-4">Telefono</label>
        <input type="number" {{readonly}} name="cel" value="{{cel}}" maxlength="45" placeholder="Número del Usuario"/>
        </section>

        <section class="row">
        <label for="messagem" class="col-4">Mensaje</label>
        <input type="text" {{readonly}} name="messagem" value="{{messagem}}" maxlength="500" placeholder="Mensaje"/>
        </section>
      
        {{if has_errors}}
            <section>
            <ul>
                {{foreach general_errors}}
                    <li>{{this}}</li>
                {{endfor general_errors}}
            </ul>
            </section>
        {{endif has_errors}}
        <section>
        {{if show_action}}
        <button type="submit" name="btnGuardar" value="G">Guardar</button>
        {{endif show_action}}
        <button type="button" id="btnCancelar">Cancelar</button>
        </section>
    </form>
    </section>


    <script>
    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById("btnCancelar").addEventListener("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=Mnt_Messages");
        });
    });
</script>