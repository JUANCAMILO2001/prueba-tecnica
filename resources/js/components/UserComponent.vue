<template>
    <div class="container">
        <div class=" row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Usuarios Disponibles <span class="float-end"><button  @click="modificar=false; abrirModal();" type="button" class="btn btn-primary">Nuevo Usuario</button></span>
                    </div>

                    <div class="card-body">
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
                                <tr v-for="u in users" :key="u.id">
                                    <th scope="row">{{u.id}}</th>
                                    <td>{{u.name}}</td>
                                    <td>{{u.lastname}}</td>
                                    <td>{{u.birthdate}}</td>
                                    <td>{{u.city_id}}</td>
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
                                        <label for="name">Ciudad</label>
                                        <input v-model="user.name" type="text" id="name" placeholder="Escriba la Ciudad" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Pais</label>
                                        <input v-model="user.lastname" type="text" id="country" placeholder="Escriba el Pais" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="population">Población</label>
                                        <input v-model="user.birthdate" type="date" id="population" placeholder="Escriba la Población" class="form-control">
                                    </div>
                                </div>

                                <!-- Modal footer -->
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
export default {
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
        }
    },
    methods:{
        async listar(){
            const res= await axios.get('/users');
            this.users=res.data;
        },
        async eliminar(id){
            const res= await axios.delete('/users/'+id);
            this.listar();
        },
        async guardar(){
            if(this.modificar){
                const res= await axios.put('/users/'+this.id,this.user);
            }else{
                const res= await axios.post('/users',this.user);
            }
            this.cerrarModal();
            this.listar();
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
                this.user.city_id=data.city_id;
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
        },
    },
    created() {
        this.listar();
    },
}
</script>
<style>
.mostrar{
    display: list-item;
    opacity: 1;
    background: rgba(44,38,75,0.849);
}

</style>
