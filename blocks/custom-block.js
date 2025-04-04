const { registerBlockType } = wp.blocks;
const { ColorPicker } = wp.components;
const { InspectorControls } = wp.editor;
const { PanelBody, PanelRow } = wp.components;
const { Fragment } = wp.element;

registerBlockType('custom/block', {
    title: 'Custom Block',
    icon: 'smiley',
    category: 'common',
    attributes: {
        backgroundColor: {
            type: 'string',
            default: '#ffffff',
        },
    },

    edit: (props) => {
        const { attributes, setAttributes } = props;
        const { backgroundColor } = attributes;

        return (
            <Fragment>
                <InspectorControls>
                    <PanelBody title="Background Settings">
                        <PanelRow>
                            <label>Background Color</label>
                            <ColorPicker
                                color={ backgroundColor }
                                onChangeComplete={(color) => setAttributes({ backgroundColor: color.hex })}
                            />
                        </PanelRow>
                    </PanelBody>
                </InspectorControls>
                <div className="custom-block" style={{ backgroundColor }}>
                    <p>Edit your content here.</p>
                </div>
            </Fragment>
        );
    },

    save: (props) => {
        const { attributes } = props;
        const { backgroundColor } = attributes;

        return (
            <div className="custom-block" style={{ backgroundColor }}>
                <p>Your content goes here!</p>
            </div>
        );
    },
});
