define([
    'uiComponent',
    'mageUtils',
    'uiRegistry',
    'uiLayout',
    'Magento_Ui/js/lib/spinner',
    'underscore'
], function (Component, utils, Registry, layout, loader, _) {
    'use strict';
    return Component.extend({
        defaults: {
            targets: {},
            settings: {},
        },
        initialize: function () {
            this._super();
            for (const [key, group] of Object.entries(this.targets)) {
                this.containerReady(group.container)
                    .then((component) => {
                        this.createComponents(key, group, component);
                    });
            }
        },

        containerReady: function (component) {
            return new Promise((resolve) => {
                Registry.get(component, (component) => {
                    component.elems.subscribe(() => {
                        resolve(component);
                    });
                });
            });
        },

        initializeModalContent: function (parentName, groupConfig) {
            if (!Registry.has(parentName + '.content')) {
                const modalContentTemplate = {
                    component: groupConfig.modal ?? 'Magecomp_Chatgptaicontent/js/modal/default',
                    parent: parentName,
                    name: 'content'
                };

                layout([modalContentTemplate]);
            }
            Registry.get(parentName + '.content', (content) => {
                content.init();
            });
        },

        createComponents: function (type, groupConfig, parent) {
            const settings = {
                ...this.settings,
                ...groupConfig,
                type
            };

            const modalTemplate = {
                parent: this.name,
                name: type + '-modal',
                component: 'Magento_Ui/js/modal/modal-component',
                config: {
                    isTemplate: true,
                    settings,
                    loader: loader.get('product_form.product_form'),
                    options: this.getModalOptions(type, groupConfig)
                }
            };

            const buttonConfig = {
                parent: parent.name,
                name: 'magecomp-ai-button-' + type,
                component: groupConfig.component,
                config: {
                    settings,
                    modalName: this.name + '.' + type + '-modal',
                    loader: loader.get('product_form.product_form')
                }
            };

            layout([buttonConfig, modalTemplate]);
        },

        getModalOptions: function(type, groupConfig) {
            const parent = this.name + '.' + type + '-modal';
            return {
                id: 'modal-'.type,
                title: 'Content AI',
                type: 'slide',
                opened: this.initializeModalContent.bind(this, parent, groupConfig),
                buttons: [
                    {
                        class: 'action primary',
                        text: 'Generate',
                        actions: [
                            {
                                targetName: parent + '.content',
                                actionName: 'generate'
                            }
                        ]
                    },
                    {
                        class: 'action primary',
                        text: 'Accept',
                        actions: [
                            {
                                targetName: parent + '.content',
                                actionName: 'saveAndClose'
                            }
                        ],
                    }
                ]
            }
        }
    });
});
