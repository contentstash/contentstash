export {};

declare global {
  type FormSchemaBaseInput = {
    label: string;
    description?: string;
    placeholder?: string;
    required?: boolean;
    component?: string;
  };

  type FormSchemaInputString = {
    type: "string";
    default?: string;
  } & FormSchemaBaseInput;

  type FormSchemaInputNumber = {
    type: "number";
    default?: number;
    min?: number;
    max?: number;
  } & FormSchemaBaseInput;

  type FormSchemaInputBoolean = {
    type: "boolean";
    default?: boolean;
  } & FormSchemaBaseInput;

  type FormSchemaInputDate = {
    type: "date";
    default?: string | Date;
  } & FormSchemaBaseInput;

  type FormSchemaInputEnum = {
    type: "enum";
    options: string[];
    default?: string;
  } & FormSchemaBaseInput;

  type FormSchemaInputArray = {
    type: "array";
    items: FormSchemaInput;
    default?: unkown[];
  } & FormSchemaBaseInput;

  type FormSchemaInput =
    | FormSchemaInputString
    | FormSchemaInputNumber
    | FormSchemaInputBoolean
    | FormSchemaInputDate
    | FormSchemaInputEnum
    | FormSchemaInputArray;

  type FormSchema = {
    [key: string]: FormSchemaInput;
  };
}
