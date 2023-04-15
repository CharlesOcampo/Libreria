<h1 style="text-align: center;">Gestión de Ordenes</h1>
<section class="WWFilter">

</section>
<section class="WWList">
    <table>
        <thead>
        <tr>
            <th>Id Orden</th>
            <th>Id Usuario</th>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Metodo Pago</th>
            <th>Direccion</th>
            <th>Cantidad Productos</th>
            <th>Precio Total</th>
            <th>Estado Pago</th>
            <th>
            {{if new_enabled}}
            <button id="btnAdd">Nuevo</button>
            {{endif new_enabled}}
            </th>
        </tr>
        </thead>
        <tbody>
        {{foreach orders}}
        <tr>
            <td style="text-align: center;">{{id}}</td>
            <td style="text-align: center;"><a href="index.php?page=Mnt_Order&mode=DSP&id={{id}}">{{user_id}}</a></td>
            <td style="text-align: center;">{{nameu}}</td>
            <td style="text-align: center;">{{cel}}</td>
            <td style="text-align: center;">{{email}}</td>
            <td style="text-align: center;">{{method}}</td>
            <td style="text-align: center;">{{addressu}}</td>
            <td style="text-align: center;">{{total_products}}</td>
            <td style="text-align: center;">{{total_price}}</td>
            <td style="text-align: center;">{{payment_status}}</td>
            <td>
            {{if ~edit_enabled}}
            <form action="index.php" method="get">
                <input type="hidden" name="page" value="mnt_order"/>
                <input type="hidden" name="mode" value="UPD" />
                <input type="hidden" name="id" value={{id}} />
                <button type="submit">Editar</button>
            </form>
            {{endif ~edit_enabled}}
            {{if ~delete_enabled}}
            <form action="index.php" method="get">
                <input type="hidden" name="page" value="mnt_order"/>
                <input type="hidden" name="mode" value="DEL" />
                <input type="hidden" name="id" value={{id}} />
                <button type="submit">Eliminar</button>
            </form>
            {{endif ~delete_enabled}}
            </td>
        </tr>
        {{endfor orders}}
        </tbody>
    </table>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("btnAdd").addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=mnt_order&mode=INS&id=0");
        });
        });
    </script>