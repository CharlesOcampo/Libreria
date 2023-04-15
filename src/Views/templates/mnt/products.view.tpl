<h1 style="text-align: center;">Gestión de Productos</h1>
<section class="WWFilter">

</section>
<section class="WWList">
    <table>
        <thead>
        <tr>
           <th>Id Producto</th> 
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>
            {{if new_enabled}}
            <button id="btnAdd">Nuevo</button>
            {{endif new_enabled}}
            </th>

        </tr>
        </thead>
        <tbody>
        {{foreach products}}
        <tr>
            <td style="text-align: center;">{{id}}</td>
            <td style="text-align: center;"><a href="index.php?page=Mnt_Product&mode=DSP&id={{id}}">{{namep}}</a></td>
            <td style="text-align: center;">{{price}}</td>
            <td style="text-align: center;">{{quantity}}</td>
            <td style="text-align: center;">{{descriptionp}}</td>
            <td style="text-align: center;">{{imagep}}</td>
            <td>
            {{if ~edit_enabled}}
            <form action="index.php" method="get">
                <input type="hidden" name="page" value="mnt_product"/>
                <input type="hidden" name="mode" value="UPD" />
                <input type="hidden" name="id" value={{id}} />
                <button type="submit">Editar</button>
            </form>
            {{endif ~edit_enabled}}
            {{if ~delete_enabled}}
            <form action="index.php" method="get">
                <input type="hidden" name="page" value="mnt_product"/>
                <input type="hidden" name="mode" value="DEL" />
                <input type="hidden" name="id" value={{id}} />
                <button type="submit">Eliminar</button>
            </form>
            {{endif ~delete_enabled}}
            </td>
        </tr>
        {{endfor products}}
        </tbody>
    </table>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("btnAdd").addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=mnt_product&mode=INS&id=0");
        });
        });
    </script>