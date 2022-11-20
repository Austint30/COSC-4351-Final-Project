
class PopUp {

    constructor(containerElement){
        if (!containerElement){
            this.createContainer();
        }
        else
        {
            this.container = containerElement;
        }

        this.render();
        
    }

    render(){

        this.container.innerHTML = `
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="lead text-center my-5">Loading</div>
                </div>
            </div>
        </div>
        `

        // Wait for renderContent to complete then set the HTML of the container to the result
        this.renderContent()
        .then((content) => {
            this.container.innerHTML = content;
            this.afterRenderContent();
        });
    }

    show(){ $(this.container).modal('show'); }
    hide(){ $(this.container).modal('hide'); }
    toggle(){ $(this.container).modal('toggle'); }

    createContainer(){
        this.container = document.createElement('div');
        this.container.className = 'modal fade';
        this.container.setAttribute('tabindex', '-1');
        this.container.setAttribute('role', 'dialog');
        this.container.setAttribute('aria-hidden', 'true');

        document.body.appendChild(this.container);
    }

    async renderContent(){
        console.warn('renderContent() not implemented in this subclass');
    }

    afterRenderContent(){

    }

    destroy(){
        this.container.innerHTML = '';
    }
}