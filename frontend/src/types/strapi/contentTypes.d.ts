// Simplified content types for frontend usage
export interface About {
  id: number;
  title: string;
  blocks: any[];
  createdAt: string;
  updatedAt: string;
}

export interface Board {
  id: number;
  year: number;
  team: OfficerTeam[];
  createdAt: string;
  updatedAt: string;
  publishedAt: string;
}

export interface Competition {
  id: number;
  title: string;
  date: string;
  excerpt?: string;
  members?: string;
  placement?: string;
  article_url?: string;
  picture?: MediaFormat;
  createdAt: string;
  updatedAt: string;
  publishedAt: string;
}

export interface Global {
  id: number;
  siteName: string;
  siteDescription: string;
  defaultSeo?: Seo;
  favicon?: MediaFormat;
  createdAt: string;
  updatedAt: string;
}

export interface Resource {
  id: number;
  title: string;
  content: string;
  createdAt: string;
  updatedAt: string;
  publishedAt: string;
}

export interface Sponsor {
  id: number;
  name: string;
  tier: 'gold' | 'silver' | 'bronze';
  logo: MediaFormat;
  url?: string;
  createdAt: string;
  updatedAt: string;
  publishedAt: string;
}

// Component types
export interface Officer {
  id: number;
  name: string;
  position: string;
  picture?: MediaFormat;
  url?: string;
}

export interface OfficerTeam {
  id: number;
  title?: string;
  officer: Officer[];
}

export interface Quote {
  id: number;
  title?: string;
  body?: string;
}

export interface RichText {
  id: number;
  body: string;
}

export interface Seo {
  id: number;
  metaTitle: string;
  metaDescription: string;
  shareImage?: MediaFormat;
}

export interface Slider {
  id: number;
  files: MediaFormat[];
}

export interface MediaFormat {
  id: number;
  name: string;
  alternativeText?: string;
  caption?: string;
  width?: number;
  height?: number;
  formats?: {
    thumbnail?: MediaFormatData;
    small?: MediaFormatData;
    medium?: MediaFormatData;
    large?: MediaFormatData;
  };
  hash: string;
  ext: string;
  mime: string;
  size: number;
  url: string;
  previewUrl?: string;
  provider: string;
  provider_metadata?: any;
  createdAt: string;
  updatedAt: string;
}

export interface MediaFormatData {
  name: string;
  hash: string;
  ext: string;
  mime: string;
  width: number;
  height: number;
  size: number;
  path?: string;
  url: string;
}

// API Response types
export interface StrapiResponse<T> {
  data: T;
  meta: {
    pagination?: {
      page: number;
      pageSize: number;
      pageCount: number;
      total: number;
    };
  };
}

export interface StrapiCollectionResponse<T> {
  data: T[];
  meta: {
    pagination: {
      page: number;
      pageSize: number;
      pageCount: number;
      total: number;
    };
  };
}

export interface StrapiError {
  status: number;
  name: string;
  message: string;
  details?: any;
}