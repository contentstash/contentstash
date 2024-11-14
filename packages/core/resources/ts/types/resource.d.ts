export {};

declare global {
  type ResourceModel = string;
  type ResourceModelData = {
    class: ResourceModel;
    title: string;
    slug: string;
  };
  type ResourceModelAttributePhpType =
    | "string"
    | "int"
    | "\\Carbon\\CarbonInterface";
  type ResourceModelAttribute = {
    name: string;
    phpType: ResourceModelAttributePhpType;
    type: string;
    increments: boolean;
    nullable: boolean;
    default: string;
    primary: boolean;
    unique: boolean;
    fillable: boolean;
    appended: null;
    cast: string;
    virtual: boolean;
    hidden: boolean;
    locked: boolean;
  };
  type ResourceModelInfo = {
    class: ResourceModel;
    fileName: string;
    connectionName: string;
    tableName: string;
    relations: never[];
    attributes: ResourceModelAttribute[];
    traits: string[];
    extra: null;
  };
}
