export {};

declare global {
  type ResourceModel = string;
  type ResourceModelData = {
    class: ResourceModel;
    title: string;
    slug: string;
  };
  type ResourceModelInfo = {
    class: ResourceModel;
    fileName: string;
    connectionName: string;
    tableName: string;
    relations: never[];
    attributes: {
      name: string;
      phpType: string;
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
    }[];
    traits: string[];
    extra: null;
  };
}
