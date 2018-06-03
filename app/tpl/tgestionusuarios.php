<?php
include 'head_common.php';
?>
<?php
use \X\Sys\Session;

/**
* Aqui comprobamos si hay session y si la hay comprobamos que sea un administrador
* el que esta acceciendo a esta parte de la web, si no lo hes lo redireccionamos a error
*/
if (!empty(Session::get('rol'))) :
    if (Session::get('rol') == 1) :
        ?>
        <div class="contenedor">
            <div class="breadcrumb">
                <ul>
                    <li><a href="<?= BARRA; ?>">home</a></li>
                    <li>&nbsp; > &nbsp;<a href="<?= BARRA; ?>gestionusuarios">gestionusuarios</a></li>
                </ul>
            </div>

            <!-- Inicio ver tabla usuarios -->
            <div class="gestionUsuarios">

                <div><h1>Gestión Usuarios</h1></div>
                <div>*(<strong>Roles: </strong> 1 = administrador, 2 = gestor, 3 = usuario)</div>

                <div class="contenedor-tabla">
                    <table class="tab_usuarios">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Contraseña</th>
                            <th>Email</th>
                            <th>Activo</th>
                            <th>*Rol</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                        </tr>
                        <?php for ($i = 0; $i < count($this->dataTable); $i++) { ?>
                            <tr>
                                <?php foreach ($this->dataTable[$i] as $key => $value) : ?>
                                    <td><?= $value; ?></td>
                                <?php endforeach; ?>
                                <td class="editUser" data-valor="<?= $this->dataTable[$i]['idUsuario']; ?>"><a href="#modUser-id">Editar</a>
                                </td>
                                <td class="delUser" data-valor="<?= $this->dataTable[$i]['idUsuario']; ?>"><a href="#">Borrar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>

            </div>
            <!-- Fin ver tabla usuarios -->

            <!-- Inicio añadir nuevo usuario -->
            <div class="gestionUsuarios">
                <div><h1>Añadir Usuario</h1></div>
                <div class="contenedor-tabla">
                    <table border class="tab_usuarios">
                        <tr>
                            <th>Nombre Usuario</th>
                            <th>Email</th>
                            <th>Contraseña</th>
                            <th>Rol</th>
                            <th></th>
                        </tr>
                        <tr>
                            <form id="adminReg" method="POST">
                                <td>
                                    <label for="username"></label>
                                    <input id="adminReg-username" name="username" type="text"
                                           placeholder="Nombre Usuario"
                                           required>
                                    <span id="adminReg-username-message"></span>
                                </td>
                                <td>
                                    <label for="email"></label>
                                    <input id="adminReg-email" name="email" type="email" placeholder="E-mail" required>
                                    <span id="adminReg-email-message"></span>
                                </td>
                                <td>
                                    <label for="password"></label>
                                    <input name="password" type="text" placeholder="Contraseña" required>
                                    <span id="adminReg-password-message"></span>
                                </td>
                                <td>
                                    <select name="rol" required>
                                        <option value="3">Usuario</option>
                                        <option value="2">Gestor</option>
                                        <option value="1">Administrador</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="submit" value="Nuevo Usuario">
                                    <span id="adminReg-registro-message"></span>
                                </td>
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin añadir nuevo usuario -->

        <!-- Inicio editar usuario -->
        <div class="gestionUsuarios">
            <div><h1>Editar Usuario</h1></div>
            <div>*(<strong>Contraseña: </strong> Si no se introduce contraseña, se queda la que ya tenia el usuario)
            </div>
            <div class="contenedor-tabla">
                <table border class="tab_usuarios">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Usuario</th>
                        <th>Contraseña</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Activo</th>
                        <th></th>
                    </tr>
                    <tr>
                        <form id="modUser" method="POST">
                            <td>
                                <label for="id"></label>
                                <input id="modUser-id" name="id" type="text" placeholder="" required readonly>
                            </td>
                            <td>
                                <label for="username"></label>
                                <input id="modUser-username" name="username" type="text"
                                       placeholder="Nombre Usuario"
                                       required>
                                <span id="modUser-username-message"></span>
                            </td>
                            <td>
                                <label for="password"></label>
                                <input id="modUser-password" name="password" type="text"
                                       placeholder="Nueva contraseña">
                                <span id="modUser-password-message"></span>
                            </td>
                            <td>
                                <label for="email"></label>
                                <input id="modUser-email" name="email" type="email" placeholder="E-mail" required>
                                <span id="modUser-email-message"></span>
                            </td>
                            <td>
                                <select id="modUser-rol" name="rol" required>
                                    <option value="3">Usuario</option>
                                    <option value="2">Gestor</option>
                                    <option value="1">Administrador</option>
                                </select>
                            </td>
                            <td>
                                <select id="modUser-activo" name="activo" required>
                                    <option value="0">Desactivar</option>
                                    <option value="1">Activar</option>
                                </select>
                            </td>
                            <td>
                                <input type="submit" value="Confirmar Edición">
                                <span id="modUser-registro-message"></span>
                            </td>
                        </form>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Fin editar usuario -->

        <?php
    		/**
    		* Mensaje a la hora de no poder gestionar usuarios
    		*/
    	 else : ?>  <h1>No tienes permisos para gestionar los usuarios</h1>
     <?php endif; else : ?>
     <h1>No tienes permisos para gestionar usuarios</h1> <?php endif; ?>


<?php
include 'footer_common.php';
?>
