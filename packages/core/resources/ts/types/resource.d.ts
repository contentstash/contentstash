export {};

declare global {
  type Resource = string;
  type ResourceData = {
    class: Resource;
    title: string;
    slug: string;
  };
  type ResourceAttributePhpType =
    | "string"
    | "int"
    | "\\Carbon\\CarbonInterface"
    | "array"
    | "mixed"
    | "bool";
  type ResourceAttributeType = "bigint" | "text" | "json";
  type ResourceAttribute = {
    name: string;
    phpType: ResourceAttributePhpType;
    type: ResourceAttributeType;
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
    attributeType: AttributeType;
  };
  type PartialResourceAttribute = Partial<
    Omit<ResourceAttribute, "name" | "attributeType" | "nullable" | "default">
  > & {
    name: string;
    attributeType: AttributeType;
    nullable: boolean;
    default: string;
    [key: string]: unknown;
  };
  type RelationType =
    | "Illuminate\\Database\\Eloquent\\Relations\\BelongsTo"
    | "Illuminate\\Database\\Eloquent\\Relations\\BelongsToMany"
    | "Illuminate\\Database\\Eloquent\\Relations\\HasMany"
    | "Illuminate\\Database\\Eloquent\\Relations\\HasOne";
  type ResourceRelation = {
    name: string;
    type: RelationType;
    related: Resource;
  };
  type ResourceInfo = {
    class: Resource;
    fileName: string;
    connectionName: string;
    tableName: string;
    relations: Record<string, ResourceRelation>;
    attributes: ResourceAttribute[];
    traits: string[];
    extra: null;
  };
  type ResourceItem = Record<string, unknown>;
}
