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
    | "\\Carbon\\CarbonInterface"
    | "array"
    | "mixed"
    | "bool";
  type ResourceModelAttributeType = "bigint" | "text" | "json";
  type ResourceModelAttribute = {
    name: string;
    phpType: ResourceModelAttributePhpType;
    type: ResourceModelAttributeType;
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
  type RelationType =
    | "Illuminate\\Database\\Eloquent\\Relations\\BelongsTo"
    | "Illuminate\\Database\\Eloquent\\Relations\\BelongsToMany"
    | "Illuminate\\Database\\Eloquent\\Relations\\HasMany"
    | "Illuminate\\Database\\Eloquent\\Relations\\HasOne";
  type ResourceModelRelation = {
    name: string;
    type: RelationType;
    related: ResourceModel;
  };
  type ResourceModelInfo = {
    class: ResourceModel;
    fileName: string;
    connectionName: string;
    tableName: string;
    relations: Record<string, ResourceModelRelation>;
    attributes: ResourceModelAttribute[];
    traits: string[];
    extra: null;
  };
  type ResourceItem = Record<string, unknown>;
}
