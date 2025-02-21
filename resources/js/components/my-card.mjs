import CustomElement from "@enhance/custom-element";

export default class MyCard extends CustomElement {
    connectedCallback() {
        // Wait for the component to render before getting the heading
        this.heading = this.querySelector("h5");
    }

    render({ html, state }) {
        const { attrs = {} } = state;
        const { title = "default" } = attrs;
        return html`
            <style>
                :host {
                    position: relative;
                    display: flex;
                    flex-direction: column;
                    min-width: 0;
                    word-wrap: break-word;
                    color: black;
                    background-color: #fff;
                    background-clip: border-box;
                    border: 1px solid rgba(0, 0, 0, 0.125);
                    border-radius: 0.25rem;
                }
                .card-img {
                    width: 100%;
                    border-top-left-radius: calc(0.25rem - 1px);
                    border-top-right-radius: calc(0.25rem - 1px);
                }
                .card-body {
                    flex: 1 1 auto;
                    padding: 1.25rem;
                }
                .card-title {
                    margin-bottom: 0.75rem;
                    font-size: 1.25rem;
                    font-weight: 500;
                }
            </style>
            <slot name="image"></slot>
            <div class="font-sans card-body">
                <h5 class="card-title">${title}</h5>
                <slot></slot>
            </div>
        `;
    }

    static get observedAttributes() {
        return ["title"];
    }

    titleChanged(value) {
        // Only update if heading exists
        if (this.heading) {
            this.heading.textContent = value;
        }
    }
}
