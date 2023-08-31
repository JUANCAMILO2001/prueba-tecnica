<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Ciudades Disponibles <span class="float-end"><button  @click="modificar=false; abrirModal();" type="button" class="btn btn-primary">Nueva Ciudad</button></span>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Pais</th>
                                <th scope="col">Población</th>
                                <th scope="col">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="ciud in ciudads" :key="ciud.id">
                                <th scope="row">{{ciud.id}}</th>
                                <td>{{ciud.name}}</td>
                                <td>{{ciud.country}}</td>
                                <td>{{ciud.population}}</td>
                                <td>
                                    <div class="btn-group">
                                        <a @click="modificar=true; abrirModal(ciud);"  class="btn btn-warning">Editar</a>
                                        <button  @click="eliminar(ciud.id)" class="btn btn-danger">Eliminar</button>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
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
                                        <input v-model="ciudad.name" type="text" id="name" placeholder="Escriba la Ciudad" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="country">Pais</label>
                                        <input v-model="ciudad.country" type="text" id="country" placeholder="Escriba el Pais" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="population">Población</label>
                                        <input v-model="ciudad.population" type="number" id="population" placeholder="Escriba la Población" class="form-control">
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
            ciudads:[],
            titulomodal:'',
            modal:0,
            modificar:true,
            ciudad:{
                name:'',
                country:'',
                population:'',
            },
            id:0,
        }
    },
    methods:{
        async listar(){
             const res= await axios.get('/ciudads');
             this.ciudads=res.data;
        },
        async eliminar(id){
            const res= await axios.delete('/ciudads/'+id);
            this.listar();
        },
        async guardar(){
            if(this.modificar){
                const res= await axios.put('/ciudads/'+this.id,this.ciudad);
            }else{
                const res= await axios.post('/ciudads',this.ciudad);
            }
            this.cerrarModal();
            this.listar();
        },
        abrirModal(data={}){
          this.modal=1;
          if(this.modificar){
              this.id=data.id;
              this.titulomodal="Editar Ciudad";
              this.ciudad.name=data.name;
              this.ciudad.country=data.country;
              this.ciudad.population=data.population;
          }else{
              this.id=0;
              this.titulomodal="Crear Ciudad";
              this.ciudad.name='';
              this.ciudad.country='';
              this.ciudad.population='';
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
