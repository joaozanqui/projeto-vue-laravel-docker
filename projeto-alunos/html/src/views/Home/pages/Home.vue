<template>
    <v-container class="bg-grey-lighten-2 mt-12">
        <v-row>
            <!-- Alunos -->
            <v-col cols="12" md="6" class="mt-4">
                <!-- Registro de alunos -->

                <v-btn
                    text="Registrar Novos Alunos"
                    block
                    @click="
                        dialogRegisterStudent = true;
                        edit = false;
                    "
                ></v-btn>

                <v-dialog
                    v-model="dialogRegisterStudent"
                    transition="dialog-top-transition"
                    width="auto"
                >
                    <v-card class="mx-auto" width="800">
                        <v-card-item class="bg-cyan-darken-1">
                            <v-card-title>
                                <span class="text-h5">Registro de Aluno</span>
                            </v-card-title>
                        </v-card-item>

                        <v-list v-if="!successMessage">
                            <v-responsive class="mx-auto" width="100%">
                                <v-text-field
                                    v-model="name"
                                    hide-details="auto"
                                    label="Nome"
                                    placeholder="Nome do Aluno"
                                ></v-text-field>
                            </v-responsive>

                            <v-responsive class="mx-auto" width="100%">
                                <v-text-field
                                    v-model="email"
                                    hide-details="auto"
                                    label="Email"
                                    placeholder="aluno@email.com"
                                    type="email"
                                ></v-text-field>
                            </v-responsive>

                            <v-responsive class="mx-auto" width="100%">
                                <v-text-field
                                    v-model="ra"
                                    hide-details="auto"
                                    label="RA"
                                    placeholder="1234567890"
                                ></v-text-field>
                            </v-responsive>

                            <v-btn
                                :loading="loading"
                                class="flex-grow-1"
                                height="48"
                                width="100%"
                                variant="tonal"
                                @click="registerClick('students', edit)"
                            >
                                Enviar
                            </v-btn>
                        </v-list>

                        <v-alert
                            v-if="successMessage"
                            title="Aluno registrado!"
                            type="success"
                        >
                            {{ successMessage }}
                        </v-alert>
                        <v-alert
                            v-if="errorMessage"
                            title="Erro ao registrar aluno!"
                            type="error"
                        >
                            {{ errorMessage }}
                        </v-alert>

                        <v-card-actions class="justify-end">
                            <v-btn
                                text="Fechar"
                                @click="this.closeDialog('register')"
                            ></v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <!-- Lista com todos os alunos registrados -->
                <v-card
                    class="mx-auto mt-4"
                    subtitle="Clique no aluno para ver suas informações e suas respectivas inscrições nas atividades."
                    width="100%"
                    outlined
                >
                    <template v-slot:title>
                        <span class="font-weight-black">Alunos</span>
                    </template>
                    <v-card-text class="bg-surface-light pt-4">
                        <v-list lines="one">
                            <v-list-item
                                v-for="(student, index) in students"
                                :key="student.id"
                                @click="
                                    searchClick('students', student);
                                    getStudentActivities(student);
                                "
                                class="clickable-item text-capitalize font-weight-bold"
                            >
                                <span>{{ student.name }}</span>
                                <v-divider
                                    v-if="index < students.length"
                                ></v-divider>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>

            <!-- Informacoes da cada aluno -->
            <v-dialog
                transition="dialog-top-transition"
                v-model="dialogStudent"
                max-width="800"
            >
                <v-card class="mx-auto" width="100%">
                    <v-card-item class="bg-cyan-darken-1">
                        <v-card-title>
                            <span class="text-h5">Informações do Aluno</span>
                        </v-card-title>
                    </v-card-item>

                    <v-list lines="one">
                        <v-divider></v-divider>
                        <v-list-item>
                            <div class="text-subtitle-1 ml-4">
                                <strong>ID de Registro:</strong>
                                {{ selectedItem.id }}
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <div class="text-subtitle-1 text-capitalize ml-4">
                                <strong>Nome:</strong> {{ selectedItem.name }}
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <div class="text-subtitle-1 ml-4">
                                <strong>Email:</strong> {{ selectedItem.email }}
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <div class="text-subtitle-1 ml-4">
                                <strong>RA:</strong> {{ selectedItem.ra }}
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                    </v-list>

                    <v-card-item class="bg-cyan-darken-1">
                        <v-card-title>
                            <span class="text-h5"
                                >Atividades em que o Aluno está Registrado</span
                            >
                        </v-card-title>
                    </v-card-item>

                    <v-list-item
                        v-for="(activity, index) in studentActivities"
                        :key="activity.id"
                        @click="searchClick('activities', activity)"
                        class="clickable-item text-capitalize font-weight-bold"
                    >
                        <v-row>
                            <v-col class="d-flex justify-start">
                                <span>{{ activity.name }}</span>
                            </v-col>
                            <v-col class="d-flex justify-end">
                                <v-btn
                                    rounded="l"
                                    size="x-small"
                                    variant="outlined"
                                    @click.stop="
                                        deleteEnroll(selectedItem, activity)
                                    "
                                    >Apagar Registro</v-btn
                                >
                            </v-col>
                        </v-row>
                        <v-divider v-if="index < activity.length"></v-divider>
                    </v-list-item>

                    <v-row>
                        <v-col class="d-flex justify-start">
                            <v-card-actions>
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="
                                        openEditDialog(selectedItem, 'students')
                                    "
                                    >Editar</v-btn
                                >
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="
                                        openConfirmDialog(
                                            selectedItem,
                                            'students'
                                        )
                                    "
                                    >Deletar Aluno</v-btn
                                >
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="
                                        addStudentInActivity('student')
                                    "
                                    >registrar em Atividade</v-btn
                                >
                            </v-card-actions>
                        </v-col>

                        <v-col class="d-flex justify-end">
                            <v-card-actions>
                                <v-btn text @click="this.closeDialog('item')"
                                    >Fechar</v-btn
                                >
                            </v-card-actions>
                        </v-col>
                    </v-row>
                </v-card>
            </v-dialog>

            <!-- Confimacao de delete -->
            <v-dialog v-model="dialogStudentDeleteConfirm" max-width="400">
                <v-card>
                    <v-card-title>Confirmar Ação</v-card-title>
                    <v-card-text>
                        Tem certeza que deseja deletar este aluno?
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            variant="outlined"
                            color="red"
                            @click="confirmDelete('students')"
                            >Confirmar</v-btn
                        >
                        <v-btn
                            variant="outlined"
                            text
                            @click="this.closeDialog('delete')"
                            >Cancelar</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- Registrar Aluno Em atividade -->
            <v-dialog
                transition="dialog-top-transition"
                v-model="dialogAddStudent"
                max-width="800"
            >
                <v-card class="mx-auto" width="100%">
                    <v-card-item class="bg-cyan-darken-1">
                        <v-card-title>
                            <span class="text-h5"
                                >Selecione as Atividades que deseja adicionar o
                                Aluno</span
                            >
                        </v-card-title>
                    </v-card-item>

                    <v-list>
                        <v-card-title v-if="filteredItens('students').length == 0">
                            <span class="text-h5"
                                >O Aluno já foi registrado em todas as atividades disponíveis.</span
                            >
                        </v-card-title>
                        <v-list-item
                            v-for="(activity, index) in filteredItens('students')"
                            :key="activity.id"
                            class="clickable-item text-capitalize font-weight-bold"
                        >
                            <v-list-item-content>
                                <v-list-item-title class="d-flex align-center">
                                    <span class="text-capitalize">{{
                                        activity.name
                                    }}</span>
                                    <v-checkbox
                                        :value="activity.id"
                                        :input-value="
                                            isSelected(
                                                activity.id,
                                                'activities'
                                            )
                                        "
                                        @change="
                                            toggleActivity(activity, 'students')
                                        "
                                        class="mt-5"
                                    ></v-checkbox>
                                </v-list-item-title>
                                <v-divider
                                    v-if="index < filteredItens('activities').length"
                                ></v-divider>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-row>
                        <v-col class="d-flex justify-start">
                            <v-card-actions>
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="enrollment('students')"
                                    >Adicionar</v-btn
                                >
                            </v-card-actions>
                        </v-col>

                        <v-col class="d-flex justify-end">
                            <v-card-actions>
                                <v-btn text @click="this.closeDialog('add')"
                                    >Fechar</v-btn
                                >
                            </v-card-actions>
                        </v-col>
                    </v-row>
                </v-card>
            </v-dialog>

            <!-- Atividades -->
            <v-col cols="12" md="6" class="mt-4">
                <!-- Registro de atividades -->

                <v-btn
                    text="Registrar Novas Atividades"
                    block
                    @click="
                        dialogRegisterActivity = true;
                        edit = false;
                    "
                ></v-btn>

                <v-dialog
                    v-model="dialogRegisterActivity"
                    transition="dialog-top-transition"
                    width="auto"
                >
                    <v-card class="mx-auto" width="800">
                        <v-card-item class="bg-cyan-darken-1">
                            <v-card-title>
                                <span class="text-h5"
                                    >Registro de Atividade</span
                                >
                            </v-card-title>
                        </v-card-item>

                        <v-list v-if="!successMessage">
                            <v-responsive class="mx-auto" width="100%">
                                <v-text-field
                                    v-model="name"
                                    hide-details="auto"
                                    label="Nome"
                                    placeholder="Nome da Atividade"
                                ></v-text-field>
                            </v-responsive>

                            <v-responsive class="mx-auto" width="100%">
                                <v-text-field
                                    v-model="description"
                                    hide-details="auto"
                                    label="Descrição"
                                    placeholder="Descrição da Atividade"
                                ></v-text-field>
                            </v-responsive>

                            <v-btn
                                :loading="loading"
                                class="flex-grow-1"
                                height="48"
                                width="100%"
                                variant="tonal"
                                @click="registerClick('activities', edit)"
                            >
                                Enviar
                            </v-btn>
                        </v-list>

                        <v-alert
                            v-if="successMessage"
                            title="Aluno registrado!"
                            type="success"
                        >
                            {{ successMessage }}
                        </v-alert>
                        <v-alert
                            v-if="errorMessage"
                            title="Erro ao registrar aluno!"
                            type="error"
                        >
                            {{ errorMessage }}
                        </v-alert>

                        <v-card-actions class="justify-end">
                            <v-btn
                                text="Fechar"
                                @click="this.closeDialog('register')"
                            ></v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <!-- Lista com todos as atividades registradas -->
                <v-card
                    class="mx-auto mt-4"
                    subtitle="Clique na atividade para ver suas informações e seus respectivos alunos inscritos."
                    width="100%"
                    outlined
                >
                    <template v-slot:title>
                        <span class="font-weight-black">Atividades</span>
                    </template>
                    <v-card-text class="bg-surface-light pt-4">
                        <v-list lines="one">
                            <v-list-item
                                v-for="(activity, index) in activities"
                                :key="activity.id"
                                @click="
                                    searchClick('activities', activity);
                                    getActivityStudents(activity);
                                "
                                class="clickable-item text-capitalize font-weight-bold"
                            >
                                <span>{{ activity.name }}</span>
                                <v-divider
                                    v-if="index < activities.length"
                                ></v-divider>
                            </v-list-item>
                        </v-list>
                    </v-card-text>
                </v-card>
            </v-col>

            <!-- Informacoes de cada atividade -->
            <v-dialog
                transition="dialog-top-transition"
                v-model="dialogActivity"
                max-width="800"
            >
                <v-card class="mx-auto" width="100%">
                    <v-card-item class="bg-cyan-darken-1">
                        <v-card-title>
                            <span class="text-h5"
                                >Informações da Atividade</span
                            >
                        </v-card-title>
                    </v-card-item>

                    <v-list lines="one">
                        <v-divider></v-divider>
                        <v-list-item>
                            <div class="text-subtitle-1 ml-4">
                                <strong>ID de Registro:</strong>
                                {{ selectedItem.id }}
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <div class="text-subtitle-1 text-capitalize ml-4">
                                <strong>Nome:</strong> {{ selectedItem.name }}
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                        <v-list-item>
                            <div class="text-subtitle-1 ml-4">
                                <strong>Descrição:</strong>
                                {{ selectedItem.description }}
                            </div>
                        </v-list-item>
                        <v-divider></v-divider>
                    </v-list>

                    <v-card-item class="bg-cyan-darken-1">
                        <v-card-title>
                            <span class="text-h5"
                                >Alunos registrados na Atividade</span
                            >
                        </v-card-title>
                    </v-card-item>

                    <v-list-item
                        v-for="(student, index) in activityStudents"
                        :key="student.id"
                        @click="searchClick('students', student)"
                        class="clickable-item text-capitalize font-weight-bold"
                    >
                        <v-row>
                            <v-col class="d-flex justify-start">
                                <span>{{ student.name }}</span>
                            </v-col>
                            <v-col class="d-flex justify-end">
                                <v-btn
                                    rounded="l"
                                    size="x-small"
                                    variant="outlined"
                                    @click.stop="
                                        deleteEnroll(student, selectedItem)
                                    "
                                    >Apagar Registro</v-btn
                                >
                            </v-col>
                        </v-row>
                        <v-divider v-if="index < student.length"></v-divider>
                    </v-list-item>

                    <v-row>
                        <v-col class="d-flex justify-start">
                            <v-card-actions>
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="
                                        openEditDialog(
                                            selectedItem,
                                            'activities'
                                        )
                                    "
                                    >Editar</v-btn
                                >
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="
                                        openConfirmDialog(
                                            selectedItem,
                                            'activities'
                                        )
                                    "
                                    >Deletar Atividade</v-btn
                                >
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="
                                        addStudentInActivity('activity')
                                    "
                                    >Registrar Alunos</v-btn
                                >
                            </v-card-actions>
                        </v-col>

                        <v-col class="d-flex justify-end">
                            <v-card-actions>
                                <v-btn text @click="this.closeDialog('item')"
                                    >Fechar</v-btn
                                >
                            </v-card-actions>
                        </v-col>
                    </v-row>
                </v-card>
            </v-dialog>

            <!-- Confimacao de delete -->
            <v-dialog v-model="dialogActivityDeleteConfirm" max-width="400">
                <v-card>
                    <v-card-title>Confirmar Ação</v-card-title>
                    <v-card-text>
                        Tem certeza que deseja deletar esta atividade?
                    </v-card-text>
                    <v-card-actions>
                        <v-btn
                            variant="outlined"
                            color="red"
                            @click="confirmDelete('activities')"
                            >Confirmar</v-btn
                        >
                        <v-btn
                            variant="outlined"
                            text
                            @click="this.closeDialog('delete')"
                            >Cancelar</v-btn
                        >
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <!-- Adicionar Aluno Na atividade -->
            <v-dialog
                transition="dialog-top-transition"
                v-model="dialogAddActivity"
                max-width="800"
            >
                <v-card class="mx-auto" width="100%">
                    <v-card-item class="bg-cyan-darken-1">
                        <v-card-title>
                            <span class="text-h5"
                                >Selecione os Alunos que deseja adicionar na
                                Atividade</span
                            >
                        </v-card-title>
                    </v-card-item>

                    <v-list>
                        <v-card-title v-if="filteredItens('activities').length == 0">
                            <span class="text-h5"
                                >Todos os Alunos disponíveis já foram registrados na Atividade.</span
                            >
                        </v-card-title>

                        <v-list-item
                            v-for="(student, index) in filteredItens('activities')"
                            :key="student.id"
                            class="clickable-item text-capitalize font-weight-bold"
                        >
                            <v-list-item-content>
                                <v-list-item-title class="d-flex align-center">
                                    <span class="text-capitalize">{{
                                        student.name
                                    }}</span>
                                    <v-checkbox
                                        :value="student.id"
                                        :input-value="
                                            isSelected(student.id, 'activities')
                                        "
                                        @change="
                                            toggleActivity(
                                                student,
                                                'activities'
                                            )
                                        "
                                        class="mt-5"
                                    ></v-checkbox>
                                </v-list-item-title>
                                <v-divider
                                    v-if="index < filteredItens('activities').length"
                                ></v-divider>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-row>
                        <v-col class="d-flex justify-start">
                            <v-card-actions>
                                <v-btn
                                    rounded="l"
                                    size="small"
                                    variant="outlined"
                                    @click.stop="enrollment('activities')"
                                    >Adicionar</v-btn
                                >
                            </v-card-actions>
                        </v-col>

                        <v-col class="d-flex justify-end">
                            <v-card-actions>
                                <v-btn text @click="this.closeDialog('add')"
                                    >Fechar</v-btn
                                >
                            </v-card-actions>
                        </v-col>
                    </v-row>
                </v-card>
            </v-dialog>
        </v-row>
    </v-container>
</template>

<script>
import api from "@/service";

export default {
    name: "HomePage",
    data() {
        return {
            students: [],
            activities: [],
            studentActivities: [],
            activityStudents: [],
            name: "",
            email: "",
            ra: "",
            description: "",

            loading: false,
            successMessage: "",
            errorMessage: "",

            edit: false,
            dialogRegisterStudent: false,
            dialogRegisterActivity: false,

            dialogStudent: false,
            dialogActivity: false,
            selectedItem: {},

            dialogStudentDeleteConfirm: false,
            dialogActivityDeleteConfirm: false,
            itemToDelete: null,
            dialogDelete: false,

            dialogAddStudent: false,
            dialogAddActivity: false,
            selectedActivities: [],
            selectedStudents: [],
        };
    },
    methods: {
        // index
        async getAll(search) {
            try {
                const res = await api.get(`/${search}`);
                if (search == "students") {
                    this.students = res.data[0];
                } else if (search == "activities") {
                    this.activities = res.data[0];
                }
            } catch (error) {
                console.error("Erro ao buscar dados:", error);
            }
        },
        // Show
        searchClick(search, item) {
            this.selectedItem = item;
            if (search == "students") {
                this.dialogStudent = true;
            } else if (search == "activities") {
                this.dialogActivity = true;
            }
        },
        // Store e Update
        async registerClick(search, edit) {
            this.loading = true;
            this.successMessage = "";
            this.errorMessage = "";
            let payload = {};

            if (search == "students") {
                payload = {
                    name: this.name,
                    email: this.email,
                    ra: this.ra,
                };
            } else if (search == "activities") {
                payload = {
                    name: this.name,
                    description: this.description,
                };
            }

            try {
                var res = {};
                if (!edit) {
                    res = await api.post(`/${search}`, payload, {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    });
                } else {
                    res = await api.put(
                        `/${search}/${this.selectedItem.id}`,
                        payload,
                        {
                            headers: {
                                "Content-Type": "application/json",
                            },
                        }
                    );
                    console.log("editção feita: ", this.selectedItem);
                }
                console.log("Dados enviados com sucesso:", res.data);

                this.name = "";
                this.email = "";
                this.ra = "";
                this.description = "";
                this.successMessage = "Dados enviados com sucesso!";
            } catch (error) {
                if (error.response) {
                    console.error("Erro ao enviar dados:", error.response.data);
                    this.errorMessage = error.response.data;
                } else {
                    console.error("Erro ao enviar dados:", error.message);
                }
            } finally {
                this.loading = false;
            }
        },

        // Destroy
        openConfirmDialog(item, search) {
            this.itemToDelete = item;
            if (search == "students") this.dialogStudentDeleteConfirm = true;
            else if (search == "activities")
                this.dialogActivityDeleteConfirm = true;
        },
        confirmDelete(search) {
            this.handleDelete(search, this.itemToDelete);
            this.closeDialog("delete");
        },
        async handleDelete(search, item) {
            try {
                const res = await api.delete(`/${search}/${item.id}`);
                console.log("Delete-", res);
                if (search == "students") this.dialogStudent = false;
                else if (search == "activities") this.dialogActivity = false;
                this.refreshData();
            } catch (error) {
                console.error("Erro ao deletar dados:", error);
            }
        },

        // Modal de edicao
        openEditDialog(item, search) {
            this.edit = true;

            if (search == "students") {
                this.name = item.name;
                this.email = item.email;
                this.ra = item.ra;
                this.dialogRegisterStudent = true;
            } else if (search == "activities") {
                this.name = item.name;
                this.description = item.description;
                this.dialogRegisterActivity = true;
            }
        },

        // Fechar Modal
        closeDialog(dialog) {
            this.dialogRegisterStudent = false;
            this.dialogRegisterActivity = false;
            this.successMessage = "";
            this.errorMessage = "";
            this.refreshData();

            console.log(this.edit, dialog);

            if (dialog == "item" || (!this.edit && dialog == "register")) {
                console.log("entrou");
                this.dialogStudent = false;
                this.dialogActivity = false;
            }

            this.dialogStudentDeleteConfirm = false;
            this.dialogActivityDeleteConfirm = false;
            this.dialogAddStudent = false;
            this.dialogAddActivity = false;

            this.name = "";
            this.email = "";
            this.ra = "";
            this.description = "";
        },

        //Mostrar itens
        filteredItens(search) {
            // if(search == 'students') {
            //     console.log("stu");
            // }
            // return this.activities.filter((activity) => {
            //         return !this.studentActivities.some(
            //             (studentActivity) => studentActivity.id === activity.id
            //         );
            //     });
            if (search == 'students') {
                return this.activities.filter((activity) => {
                    return !this.studentActivities.some(
                        (studentActivity) => studentActivity.id === activity.id
                    );
                });
            } else if (search == 'activities') {
                return this.students.filter((student) => {
                    return !this.activityStudents.some(
                        (activityStudent) => activityStudent.id === student.id
                    );
                });
            }
        },

        // Registros
        async getStudentActivities(student) {
            try {
                const res = await api.get(`/students/${student.id}/activities`);
                this.studentActivities = res.data;
            } catch (error) {
                console.error("Erro ao buscar dados:", error);
            }
        },

        async getActivityStudents(activity) {
            try {
                const res = await api.get(
                    `/activities/${activity.id}/students`
                );
                this.activityStudents = res.data;
            } catch (error) {
                console.error("Erro ao buscar dados:", error);
            }
        },

        isSelected(itemId, search) {
            if (search == "students")
                return this.selectedActivities.includes(itemId);
            else if (search == "activities")
                return this.selectedStudents.includes(itemId);
        },

        toggleActivity(item, search) {
            var index = null;
            if (search == "students") {
                index = this.selectedActivities.indexOf(item.id);

                if (index === -1) {
                    this.selectedActivities.push(item.id);
                } else {
                    this.selectedActivities.splice(index, 1);
                }
            } else if (search == "activities") {
                index = this.selectedStudents.indexOf(item.id);

                if (index === -1) {
                    this.selectedStudents.push(item.id);
                } else {
                    this.selectedStudents.splice(index, 1);
                }
            }
        },

        addStudentInActivity(search) {
            if (search == "student") this.dialogAddStudent = true;
            else if (search == "activity") this.dialogAddActivity = true;
        },

        async enrollment(search) {
            this.loading = true;
            try {
                if (search == "students") {
                    for (const activityId of this.selectedActivities) {
                        await api.post(
                            `/students/${this.selectedItem.id}/activities/${activityId}`
                        );
                    }
                } else if (search == "activities") {
                    for (const studentId of this.selectedStudents) {
                        await api.post(
                            `/students/${studentId}/activities/${this.selectedItem.id}`
                        );
                    }
                }

                console.log("Dados enviados com sucesso!");
                this.selectedActivities = [];
                this.closeDialog("add");
                if (search == "students")
                    this.refreshInfos(this.selectedItem, null);
                else if (search == "activities")
                    this.refreshInfos(null, this.selectedItem);
                this.successMessage = "Dados enviados com sucesso!";
            } catch (error) {
                if (error.response) {
                    console.error("Erro ao enviar dados:", error.response.data);
                    this.errorMessage = error.response.data;
                } else {
                    console.error("Erro ao enviar dados:", error.message);
                }
            } finally {
                this.loading = false;
            }
        },

        async deleteEnroll(student, activity) {
            try {
                const res = await api.delete(
                    `/students/${student.id}/activities/${activity.id}`
                );
                console.log("Delete-", res);
                this.refreshData();
                this.refreshInfos(student, activity);
            } catch (error) {
                console.error("Erro ao deletar dados:", error);
            }
        },

        // Atualizar as listas
        refreshData() {
            this.getAll("students");
            this.getAll("activities");
        },

        refreshInfos(student = null, activity = null) {
            if (student) {
                this.getStudentActivities(student);
            } else if (activity) {
                this.getActivityStudents(activity);
            }
        },
    },

    created() {
        this.refreshData();
    },
};
</script>

<style lang=""></style>
