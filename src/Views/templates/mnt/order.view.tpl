<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_Order&mode={{mode}}&id={{id}}"
        method="POST"
        class="col-6 col-3-offset"
    >
        <section class="row">
        <label for="id" class="col-4">Id Orden</label>
        <input type="hidden" id="id" name="id" value="{{id}}"/>
        <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
        <input type="text" readonly name="iddummy" value="{{id}}"/>
        </section>

         <section class="row">
        <label for="user_id" class="col-4">Usuario Id</label>
        <input type="number" {{readonly}} name="user_id" value="{{user_id}}" maxlength="45" placeholder="Id de Usuario"/>
        </section>

        <section class="row">
        <label for="nameu" class="col-4">Nombre</label>
        <input type="text" {{readonly}} name="nameu" value="{{nameu}}" maxlength="45" placeholder="Nombre de Usuario"/>
        </section>

        <section class="row">
        <label for="cel" class="col-4">Telefono</label>
        <input type="number" {{readonly}} name="cel" value="{{cel}}" maxlength="45" placeholder="Número del Usuario"/>
        </section>

         <section class="row">
        <label for="email" class="col-4">Correo</label>
        <input type="mail" {{readonly}} name="email" value="{{email}}" maxlength="100" placeholder="Correo del Usuario"/>
        </section>


        <section class="row">
        <label for="method" class="col-4">Metodo Pago</label>
        <input type="text" {{readonly}} name="method" value="{{method}}" maxlength="45" placeholder="Metodo de Pago"/>
        </section>
        
        <section class="row">
        <label for="addressu" class="col-4">Dirección</label>
        <input type="text" {{readonly}} name="addressu" value="{{addressu}}" maxlength="45" placeholder="Dirección del Usuario"/>
        </section>

        <section class="row">
        <label for="total_products" class="col-4">Cantidad de productos</label>
        <input type="number" {{readonly}} name="total_products" value="{{total_products}}" maxlength="45" placeholder="Cantidad de productos"/>
        </section>

         <section class="row">
        <label for="total_price" class="col-4">Total</label>
        <input type="number" {{readonly}} name="total_price" value="{{total_price}}" maxlength="45" placeholder="Total "/>
        </section>

        <section class="row">
        <label for="payment_status" class="col-4">Estado</label>
        <select id="payment_status" name="payment_status" {{if readonly}}disabled{{endif readonly}}>
            <option value="Pendiente" {{payment_status_Pendiente}}>Pendiente</option>
            <option value="Completado" {{payment_status_Completado}}>Completado</option>
        </select>
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
            window.location.assign("index.php?page=Mnt_Orders");
        });
    });
</script>