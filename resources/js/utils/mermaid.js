export const definitionToMermaid = (definitions) => {
    return definitions.map(({id, name}) => `${id}[${name}]`).join('\n');
}

export const relationsToMermaid = (relations) => {
    return relations.map(({start, end}) => `${start} --> ${end}`).join('\n');
}

export const statusToMermaid = (status) => {
    return status.map(({ id, style }) => `class ${id} status-${style}`).join('\n');
}
