



wp.blocks.registerBlockType('twobytecode/assignment', {
  title: 'Assignment',
  icon: 'smiley',
  category: 'common',
  attributes: {
    question: { type: 'string' },
    answer: { type: 'string' }
  },

  edit: function (props) {
    function updateContent(event) {
      props.setAttributes({ question: event.target.value });
    }
    function updateContent2(event) {
      props.setAttributes({ answer: event.target.value });
    }

    return React.createElement(
      "div",
      { style: { width: "100%", border: "2px solid rgba(0, 0, 0, 15%)", padding: "20px" } },
      React.createElement("textarea", { type: "text", id: "assignmentQuestion", rows: 2, value: props.attributes.question, placeholder: "Question", style: { width: "100%" }, onChange: updateContent }),
      React.createElement("textarea", { type: "text", id: "assignmentAnswer", rows: 5, value: props.attributes.answer, placeholder: "Answer", style: { width: "100%" }, onChange: updateContent2 }),
    );
  },
  save: function (props) {
    return wp.element.createElement(
      "textarea",
      { id: "assignment-block" },
      props.attributes.question + `<br/>` +
      props.attributes.answer,
    );
  }
})