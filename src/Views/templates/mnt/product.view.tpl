<h1>{{modedsc}}</h1>
<section class="row">
    <form action="index.php?page=Mnt_Product&mode={{mode}}&id={{id}}"
        method="POST"
        class="col-6 col-3-offset"
    >
        
  <section class="row">
        <label for="id" class="col-4">Id Producto</label>
        <input type="hidden" id="id" name="id" value="{{id}}"/>
        <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
        <input type="text" readonly name="iddummy" value="{{id}}"/>
        </section>

        <section class="row">
        <label for="namep" class="col-4">Nombre</label>
        <input type="text" {{readonly}} name="namep" value="{{namep}}" maxlength="45" placeholder="Nombre de Producto"/>
        </section>

        <section class="row">
        <label for="price" class="col-4">Precio</label>
        <input type="number" {{readonly}} name="price" value="{{price}}" maxlength="45" placeholder="Precio del Producto"/>
        </section>

        <section class="row">
        <label for="quantity" class="col-4">Cantidad</label>
        <input type="number" {{readonly}} name="quantity" value="{{quantity}}" maxlength="45" placeholder="Cantidad de Productos"/>
        </section>

         <section class="row">
        <label for="descriptionp" class="col-4">Descripción</label>
        <input type="text" {{readonly}} name="descriptionp" value="{{descriptionp}}" maxlength="100" placeholder="Descripción del producto"/>
        </section>

        <section class="row">
        <label for="imagep" class="col-4">Imagen</label>
        <input type="text" {{readonly}} name="imagep" value="{{imagep}}" maxlength="100" placeholder="url de la imagen"/>
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
            window.location.assign("index.php?page=Mnt_Products");
        });
    });
</script>
