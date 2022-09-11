export const definitionToMermaid = (definitions) => {
    return definitions.map(({id, name}) => `${id}[${name}]`).join('\n');
}

export const relationsToMermaid = (relations) => {
    return relations.map(({start, end}) => `${start} --> ${end}`).join('\n');
}

export const statusToMermaid = (status, styles) => {
    return status.map(({ id, style }) => `style ${id} ${styles[style]}`).join('\n');
}
