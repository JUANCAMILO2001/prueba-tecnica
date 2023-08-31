<template>
    <div class="container">
        <div class=" row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Usuarios Disponibles <span class="float-end"><button  @click="modificar=false; abrirModal();" type="button" class="btn btn-primary">Nuevo Usuario</button></span>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="filterName">Filtrar por Nombre</label>
                                    <input v-model="filters.name" type="text" id="filterName" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="filterLastName">Filtrar por Apellido</label>
                                    <input v-model="filters.lastname" type="text" id="filterLastName" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="filterDocumentNumber">Filtrar por Número de Documento</label>
                                    <input v-model="filters.documentNumber" type="number" id="filterDocumentNumber" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label for="filterCity">Filtrar por Ciudad</label>
                                    <select v-model="filters.city" id="filterCity" class="form-control">
                                        <option value="">Todas las Ciudades</option>
                                        <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Apellido</th>
                                    <th scope="col">Fecha Nacimiento</th>
                                    <th scope="col">Ciudad Nacimiento</th>
                                    <th scope="col">Tipo Documento</th>
                                    <th scope="col">Numero Documento</th>
                                    <th scope="col">Correo Electronico</th>
                                    <th scope="col">Apodo Usuario</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="u in filteredUsers" :key="u.id">
                                    <th scope="row">{{u.id}}</th>
                                    <td>{{u.name}}</td>
                                    <td>{{u.lastname}}</td>
                                    <td>{{u.birthdate}}</td>
                                    <td>{{cityNames[u.city_id]}}</td>
                                    <td>{{u.document_type}}</td>
                                    <td>{{u.document_number}}</td>
                                    <td>{{u.email}}</td>
                                    <td>{{u.username}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a @click="modificar=true; abrirModal(u);"  class="btn btn-warning">Editar</a>
                                            <button  @click="eliminar(u.id)" class="btn btn-danger">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- The Modal -->
                    <div class="modal" :class="{mostrar:modal}">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">{{titulomodal}}</h4>
                                    <button type="button" class="close" data-dismiss="modal" @click="cerrarModal();">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name">Nombre</label>
                                        <input v-model="user.name" type="text" id="name" placeholder="Escriba el nombre" class="form-control">
                                        <span class="text-danger" v-if="errores.name">{{errores.name[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname">Apellido</label>
                                        <input v-model="user.lastname" type="text" id="lastname" placeholder="Escriba el apellido" class="form-control">
                                        <span class="text-danger" v-if="errores.lastname">{{errores.lastname[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="birthdate">Fecha Nacimiento</label>
                                        <input v-model="user.birthdate" type="date" id="birthdate" placeholder="Escriba fecha nacimiento" class="form-control">
                                        <span class="text-danger" v-if="errores.birthdate">{{errores.birthdate[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="city_id">Ciudad Nacimiento</label>
                                        <select v-model="user.city_id" id="city_id" class="form-control">
                                            <option value="">Seleccionar Ciudad</option>
                                            <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                                        </select>
                                        <span class="text-danger" v-if="errores.city_id">{{errores.city_id[0]}}</span>

                                    </div>

                                    <div class="mb-3">
                                        <label for="document_type">Tipo Documento</label>
                                        <input v-model="user.document_type" type="text" id="document_type" placeholder="Escriba el tipo de documento" class="form-control">
                                        <span class="text-danger" v-if="errores.document_type">{{errores.document_type[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="document_number">Numero Documento</label>
                                        <input v-model="user.document_number" type="number" id="document_number" placeholder="Escriba el numero documento" class="form-control">
                                        <span class="text-danger" v-if="errores.document_number">{{errores.document_number[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Correo Eléctronico</label>
                                        <input v-model="user.email" type="email" id="email" placeholder="Escriba el correo eléctronico" class="form-control">
                                        <span class="text-danger" v-if="errores.email">{{errores.email[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username">Apodo Usuario</label>
                                        <input v-model="user.username" type="text" id="username" placeholder="Escriba el apodo del usuario" class="form-control">
                                        <span class="text-danger" v-if="errores.username">{{errores.username[0]}}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Contraseña</label>
                                        <input v-model="user.password" type="password" id="password" class="form-control">
                                        <span class="text-danger" v-if="errores.password">{{errores.password[0]}}</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="cerrarModal();" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    <button  @click="guardar();"  type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Chart } from 'chart.js/auto';
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
    mounted() {
        this.fetchAndCreateChart();
    },
    data(){
        return{
            users:[],
            titulomodal:'',
            modal:0,
            modificar:true,
            user:{
                document_type:'',
                document_number:'',
                name:'',
                lastname:'',
                birthdate:'',
                city_id:'',
                email:'',
                username:'',
                password:'',
            },
            id:0,
            cityNames: {},
            filters: {
                name: '',
                lastname: '',
                city: '',
                documentNumber: '',
            },
            cities: [],
            errores:{},
        }
    },
    methods:{
        async listar() {
            const res = await axios.get('/users');
            this.users = res.data;
            for (const user of this.users) {
                await this.getCityName(user.city_id);
            }
            const citiesResponse = await axios.get('/ciudads');
            this.cities = citiesResponse.data;
        },
        applyFilters() {
            const filteredUsers = this.users.filter(user => {
                const nameMatch = user.name.toLowerCase().includes(this.filters.name.toLowerCase());
                const lastnameMatch = user.lastname.toLowerCase().includes(this.filters.lastname.toLowerCase());
                const cityMatch = !this.filters.city || user.city_id === this.filters.city;
                const documentNumberMatch = !this.filters.documentNumber || user.document_number.toString().includes(this.filters.documentNumber.toString()); // Filtrar si no se ingresa número de documento o si coincide con el número ingresado
                return nameMatch && lastnameMatch && cityMatch && documentNumberMatch;
            });

            return filteredUsers;
        },
        async getCityName(cityId) {
            try {
                const response = await axios.get(`/ciudads/${cityId}`);
                this.$set(this.cityNames, cityId, response.data.name);
            } catch (error) {
                console.error('Error fetching city:', error);
                this.$set(this.cityNames, cityId, 'N/A');
            }
        },
        async eliminar(id) {
            try {
                const res = await axios.delete('/users/' + id);
                this.listar();

                Swal.fire({
                    icon: 'success',
                    title: 'Usuario eliminado',
                    text: 'El usuario ha sido eliminado correctamente.',
                });
            } catch (error) {
                console.error('Error al eliminar:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al eliminar',
                    text: 'Ocurrió un error al intentar eliminar el usuario.',
                });
            }
        },
        async guardar() {
            try {
                if (this.modificar) {
                    const res = await axios.put('/users/' + this.id, this.user);
                } else {
                    // Remove password if it's empty
                    if (this.user.password.trim() !== '') {
                        this.user.password = this.user.password.trim(); // Remove extra spaces
                    } else {
                        delete this.user.password;
                    }
                    const res = await axios.post('/users', this.user);
                }
                this.cerrarModal();
                this.listar();
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario guardado',
                    text: 'El usuario ha sido guardado correctamente.',
                });
            }catch (error){
                if(error.response.data){
                    this.errores=error.response.data.errors
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: 'Ocurrió un error al intentar guardar el usuario.',
                });
            }
        },


        abrirModal(data={}){
            this.modal=1;
            if(this.modificar){
                this.id=data.id;
                this.titulomodal="Editar Usuario";
                this.user.document_type=data.document_type;
                this.user.document_number=data.document_number;
                this.user.name=data.name;
                this.user.lastname=data.lastname;
                this.user.birthdate=data.birthdate;
                this.user.city_id = data.city_id;
                this.user.email=data.email;
                this.user.username=data.username;
                this.user.password=data.password;
            }else{
                this.id=0;
                this.titulomodal="Crear Usuario";
                this.user.document_type='';
                this.user.document_number='';
                this.user.name='';
                this.user.lastname='';
                this.user.birthdate='';
                this.user.city_id='';
                this.user.email='';
                this.user.username='';
                this.user.password='';
            }
        },
        cerrarModal(){
            this.modal=0;
            this.errores={};
        },
    },
    created() {
        this.listar();
    },
    computed: {
        filteredUsers() {
            return this.applyFilters();
        }
    },
}
</script>

