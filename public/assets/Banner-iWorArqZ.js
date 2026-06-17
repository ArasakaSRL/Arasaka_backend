import{t as e}from"./jsx-runtime-H2Lj-n6k.js";import{t}from"./createLucideIcon-BburKnk4.js";import{t as n}from"./trash-2-DOCYdO7W.js";var r=t(`bookmark-x`,[[`path`,{d:`m14.5 7.5-5 5`,key:`3lb6iw`}],[`path`,{d:`M17 3a2 2 0 0 1 2 2v15a1 1 0 0 1-1.496.868l-4.512-2.578a2 2 0 0 0-1.984 0l-4.512 2.578A1 1 0 0 1 5 20V5a2 2 0 0 1 2-2z`,key:`oz39mx`}],[`path`,{d:`m9.5 7.5 5 5`,key:`ko136h`}]]),i=t(`circle-plus`,[[`circle`,{cx:`12`,cy:`12`,r:`10`,key:`1mglay`}],[`path`,{d:`M8 12h8`,key:`1wcyev`}],[`path`,{d:`M12 8v8`,key:`napkw2`}]]),a=t(`square-pen`,[[`path`,{d:`M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7`,key:`1m0v6g`}],[`path`,{d:`M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z`,key:`ohrbg2`}]]),o=e();function s({children:e,onClick:t,className:n,disabled:r}){return(0,o.jsx)(`button`,{onClick:t,disabled:r,className:`
        bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg font-medium-ui transition
        ${r?`opacity-50 cursor-not-allowed hover:bg-primary-500`:``}
        ${n||``}
      `,children:e})}var c=({titulo:e,descripcion:t,totalItems:c=0,editando:l,eliminando:u,cantidadSeleccionados:d=0,onAgregar:f,onEditar:p,onCancelar:m,onEliminar:h})=>(0,o.jsxs)(`div`,{className:`\r
        w-full\r
        rounded-xl\r
        px-6 py-6\r
        md:px-8 md:py-8\r
        text-white\r
        bg-linear-to-br\r
        from-[#0a1a3a]\r
        to-[#112e57]\r
        flex flex-col\r
        items-start\r
        gap-3\r
      `,children:[(0,o.jsxs)(`div`,{children:[(0,o.jsx)(`h1`,{className:`\r
            text-2xl\r
            md:text-4xl\r
            font-bold\r
            text-left\r
          `,children:(e=>{let t=e.split(` `);if(t.length<=1)return e;let n=Math.ceil(t.length/2),r=t.slice(0,n).join(` `),i=t.slice(n).join(` `);return(0,o.jsxs)(o.Fragment,{children:[(0,o.jsx)(`span`,{className:`block`,children:r}),(0,o.jsx)(`span`,{className:`block`,children:i})]})})(e)}),(0,o.jsx)(`p`,{className:`\r
            text-sm\r
            md:text-base\r
            text-left\r
            text-gray-200\r
          `,children:t})]}),(0,o.jsxs)(`div`,{className:`flex flex-wrap gap-3`,children:[f&&(0,o.jsxs)(s,{onClick:f,className:`\r
              mt-1\r
              px-3 py-2\r
              sm:px-4 sm:py-1.5\r
              bg-blue-600\r
              hover:bg-blue-700\r
              text-xs sm:text-sm\r
              flex items-center\r
              justify-center\r
              gap-2\r
            `,children:[(0,o.jsx)(i,{size:16}),(0,o.jsx)(`span`,{children:`Agregar`})]}),c>0&&(p||h)&&(0,o.jsxs)(o.Fragment,{children:[p&&(l?(0,o.jsxs)(s,{onClick:m,className:`\r
                    mt-1\r
                    px-3 py-2\r
                    sm:px-4 sm:py-1.5\r
                    bg-gray-500\r
                    hover:bg-gray-600\r
                    text-xs sm:text-sm\r
                    flex items-center\r
                    justify-center\r
                    gap-2\r
                    min-w-11\r
                  `,children:[(0,o.jsx)(r,{size:16}),(0,o.jsx)(`span`,{className:`hidden sm:inline`,children:`Cancelar`})]}):(0,o.jsxs)(s,{onClick:p,className:`\r
                    mt-1\r
                    px-3 py-2\r
                    sm:px-4 sm:py-1.5\r
                    bg-blue-600\r
                    hover:bg-blue-700\r
                    text-xs sm:text-sm\r
                    flex items-center\r
                    justify-center\r
                    gap-2\r
                    min-w-11\r
                  `,children:[(0,o.jsx)(a,{size:16}),(0,o.jsx)(`span`,{className:`hidden sm:inline`,children:`Editar`})]})),h&&(0,o.jsx)(s,{onClick:u?m:h,className:`
                  mt-1
                  px-3 py-2
                  sm:px-4 sm:py-1.5
                  text-xs sm:text-sm
                  flex items-center
                  justify-center
                  gap-2
                  min-w-11
                  ${u?`bg-gray-500 hover:bg-gray-600`:`bg-red-600 hover:bg-red-700`}
                `,children:u?(0,o.jsxs)(o.Fragment,{children:[(0,o.jsx)(r,{size:16}),(0,o.jsx)(`span`,{className:`hidden sm:inline`,children:`Cancelar`})]}):(0,o.jsxs)(o.Fragment,{children:[(0,o.jsx)(n,{size:16}),(0,o.jsx)(`span`,{className:`hidden sm:inline`,children:`Eliminar`})]})})]})]})]});export{s as n,c as t};