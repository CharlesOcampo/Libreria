<h1 style="text-align: center;">Gestión de Mensajes</h1>
<section class="WWFilter">

</section>
<section class="WWList">
    <table>
        <thead>
        <tr>
            <th>Id Mensaje</th>
            <th>Id Usuario</th>
            <th>Nombre</th>
             <th>Correo</th>
            <th>Telefono</th>
            <th>Mensaje</th>
            <th>
            {{if new_enabled}}
            <button id="btnAdd">Nuevo</button>
            {{endif new_enabled}}
            </th>
        </tr>
        </thead>
        <tbody>
        {{foreach messages}}
        <tr>
            <td style="text-align: center;">{{id}}</td>
            <td style="text-align: center;">{{user_id}}</td>
            <td style="text-align: center;"><a href="index.php?page=Mnt_Message&mode=DSP&id={{id}}">{{namem}}</a></td>
            <td style="text-align: center;">{{email}}</td>
            <td style="text-align: center;">{{cel}}</td>
            <td style="text-align: center;">{{messagem}}</td>
            <td>
            {{if ~edit_enabled}}
            <form action="index.php" method="get">
                <input type="hidden" name="page" value="Mnt_Message"/>
                <input type="hidden" name="mode" value="UPD" />
                <input type="hidden" name="id" value={{id}} />
                <button type="submit">Editar</button>
            </form>
            {{endif ~edit_enabled}}
            {{if ~delete_enabled}}
            <form action="index.php" method="get">
                <input type="hidden" name="page" value="Mnt_Message"/>
                <input type="hidden" name="mode" value="DEL" />
                <input type="hidden" name="id" value={{id}} />
                <button type="submit">Eliminar</button>
            </form>
            {{endif ~delete_enabled}}
            </td>
        </tr>
        {{endfor messages}}
        </tbody>
    </table>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("btnAdd").addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            window.location.assign("index.php?page=mnt_message&mode=INS&id=0");
        });
        });
    </script>