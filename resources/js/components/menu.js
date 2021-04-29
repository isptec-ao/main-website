export const menuItems = [
    {
        id: 1,
        label: "menuitems.menu.text",
        isTitle: true
    },
    {
        id: 2,
        label: "Dashboard",
        icon: "bx-home-circle",
        link: route('canvas.dashboard'),
    },
    {
        id: 3,
        label: "Notícias e Eventos",
        icon: "bx-receipt",
        subItems: [
            {
                id: 4,
                label: "Notícias",
                link: route('canvas.posts.index'),
                parentId: 3
            },
            {
                id: 5,
                label: "Eventos",
                link: route('canvas.events.index'),
                parentId: 3
            },
            {
                id: 6,
                label: "Etiquetas",
                link: route('canvas.tags.index'),
                parentId: 3
            },
            {
                id: 7,
                label: "Tópicos",
                link: route('canvas.topics.index'),
                parentId: 3
            },
            {
                id: 54,
                label: "Conteúdo Submetido",
                link: route('canvas.contentsubmissions.index'),
                parentId: 3
            }
        ]
    },
    {
        id: 55,
        label: "ISPTEC na Mídia",
        icon: "bx bx-tv",
        subItems: [
            {
                id: 56,
                label: "CAT. Mídia",
                link: route('canvas.mediacategories.index'),
                parentId: 55
            },
            {
                id: 57,
                label: "ISPTEC na Mídia",
                link: route('canvas.isptecmedia.index'),
                parentId: 55
            },
        ]
    },
    {
        id: 8,
        label: "Funcionários e Felicitações",
        icon: "bxs-user-detail",
        subItems: [
            {
                id: 9,
                label: "Funcionários",
                link: route('canvas.employees.index'),
                parentId: 8
            },
            {
                id: 10,
                label: "Felicitações",
                link: route('canvas.messages.index'),
                parentId: 8
            },
            {
                id: 11,
                label: "Etiquetas",
                link: route('canvas.tags.index'),
                parentId: 8
            },
            {
                id: 12,
                label: "Tópicos",
                link: route('canvas.topics.index'),
                parentId: 8
            }
        ]
    },

    {
        id: 13,
        label: "Departamentos e Serviços",
        icon: "bx-store",
        subItems: [
            {
                id: 14,
                label: "Departamentos",
                link: route('canvas.departments.index'),
                parentId: 13
            },
            {
                id: 15,
                label: "CAT. Serviços",
                link: route('canvas.servicecategories.index'),
                parentId: 13
            },
            {
                id: 16,
                label: "Serviços",
                link: route('canvas.services.index'),
                parentId: 13
            }
        ]
    },

    {
        id: 17,
        label: "PUB. Revistas",
        icon: "bx-detail",
        subItems: [
            {
                id: 18,
                label: "CAT. Revistas",
                link: route('canvas.journalcategories.index'),
                parentId: 17
            },
            {
                id: 19,
                label: "Publicações",
                link: route('canvas.journalpublications.index'),
                parentId: 17
            }
        ]
    },

    {
        id: 20,
        label: "Cursos",
        icon: "bx-list-ul",
        subItems: [
            {
                id: 21,
                label: "CAT. Cursos",
                link: route('canvas.coursecategories.index'),
                parentId: 20
            },
            {
                id: 22,
                label: "Cursos",
                link: route('canvas.courses.index'),
                parentId: 20
            },
            {
                id: 23,
                label: "Disciplinas",
                link: route('canvas.subjects.index'),
                parentId: 20
            },
            {
                id: 24,
                label: "Semestres",
                link: route('canvas.semesters.index'),
                parentId: 20
            },
            {
                id: 25,
                label: "Plano Curricular",
                link: route('canvas.courseplans.index'),
                parentId: 20
            },
        ]
    },

    {
        id: 26,
        label: "Recrutamento",
        icon: "bx-task",
        subItems: [
            {
                id: 27,
                label: "CAT. Recrutamento",
                link: route('canvas.recruitmentcategories.index'),
                parentId: 26
            },
            {
                id: 28,
                label: "PUB. Vagas",
                link: route('canvas.recruitmentpublications.index'),
                parentId: 26
            },
            {
                id: 29,
                label: "Candidaturas",
                link: route('canvas.recruitmentsubmissions.index'),
                parentId: 26
            },
            {
                id: 30,
                label: "Graus Académicos",
                link: route('canvas.academiccategories.index'),
                parentId: 26
            }
        ]
    },

    {
        id: 31,
        label: "CEL",
        icon: "bx-aperture",
        subItems: [
            {
                id: 32,
                label: "CAT. Clube",
                link: route('canvas.celcategories.index'),
                parentId: 31
            },
            {
                id: 33,
                label: "MEMB. Clube",
                link: route('canvas.clubmemberships.index'),
                parentId: 31
            },
            {
                id: 53,
                label: "SESS. Clube",
                link: route('canvas.clubsessions.index'),
                parentId: 31
            },
        ]
    },

    {
        id: 34,
        label: "PÁG. e SEC.",
        icon: "bx-file",
        subItems: [
            {
                id: 35,
                label: "Páginas",
                link: route('canvas.pages.index'),
                parentId: 34
            },
            {
                id: 36,
                label: "Secções",
                link: route('canvas.sections.index'),
                parentId: 34
            },
            {
                id: 37,
                label: "Sliders",
                link: route('canvas.sliders.index'),
                parentId: 34
            }
        ]
    },

    {
        id: 38,
        label: "ALUMNI",
        icon: "bx-user",
        link: route('canvas.alumnis.index'),
    },

    {
        id: 40,
        label: "Parcerias",
        icon: "bx-detail",
        subItems: [
            {
                id: 41,
                label: "CAT. Parceiros",
                link: route('canvas.partnercategories.index'),
                parentId: 40
            },
            {
                id: 42,
                label: "Parceiros",
                link: route('canvas.partnerships.index'),
                parentId: 40
            }
        ]
    },

    {
        id: 43,
        label: "Newsletter",
        icon: "bx-detail",
        subItems: [
            {
                id: 44,
                label: "CAT. Newsletter",
                link: route('canvas.newslettercategories.index'),
                parentId: 43
            },
            {
                id: 45,
                label: "Inscrições",
                link: route('canvas.newslettersubscriptions.index'),
                parentId: 43
            }
        ]
    },

    {
        id: 46,
        label: "Ficheiros",
        icon: "bx-detail",
        subItems: [
            {
                id: 47,
                label: "CAT. Ficheiro",
                link: route('canvas.filecategories.index'),
                parentId: 46
            },
            {
                id: 48,
                label: "Ficheiros",
                link: route('canvas.files.index'),
                parentId: 46
            }
        ]
    },

    {
        id: 49,
        label: "CCD",
        icon: "bxs-graduation",
        subItems: [
            {
                id: 50,
                label: "Cursos",
                link: route('canvas.shortcourses.index'),
                parentId: 49
            },
            {
                id: 51,
                label: "Turmas",
                link: route('canvas.shortcourseclasses.index'),
                parentId: 49
            },
            {
                id: 52,
                label: "Inscrições",
                link: route('canvas.shortcourseregistrations.index'),
                parentId: 49
            },
        ]
    },

    {
        id: 39,
        label: "Definições",
        icon: "bx-cog",
        link: route('canvas.settings.index'),
    }
];
