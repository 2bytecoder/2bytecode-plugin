 
wp.blocks.registerBlockType('twobytecode/dart-code', {
    title: 'Dart Code',
    icon: 'heart',
    category: 'common',
    attributes: {
      content: {type: 'string'}
    },
    
    edit: function(props) {
      function updateContent(event) {
        props.setAttributes({content: event.target.value})
      }
      
      return React.createElement(
        "div",
        null,
        React.createElement("textarea", { type: "text", id:"codeZone", rows: 10 ,value: props.attributes.content, style: {width: "100%"}, onChange: updateContent }),
      );
    },
    save: function(props) {
      return wp.element.createElement(
        "textarea",
        {id : "codeZone" },
        props.attributes.content
      );
    }
  })