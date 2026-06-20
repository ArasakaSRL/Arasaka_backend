import{t as e}from"./jsx-runtime-H2Lj-n6k.js";import{t}from"./trash-2-DOCYdO7W.js";import{t as n}from"./proxy-C10A6I12.js";import{t as r}from"./AnimatePresence-Cj8_Tyc1.js";var i=e(),a=({isOpen:e,closeModal:t,children:a,maxWidth:o=`max-w-md`})=>(0,i.jsx)(r,{children:e&&(0,i.jsx)(n.div,{className:`\r
            fixed inset-0 z-50\r
            flex items-center justify-center\r
            bg-black/40\r
            p-4\r
          `,onClick:t,initial:{opacity:0},animate:{opacity:1},exit:{opacity:0},children:(0,i.jsx)(n.div,{className:`
              w-full
              ${o}
              bg-white
              rounded-2xl
              shadow-xl
              max-h-[90vh]
              overflow-y-auto
            `,onClick:e=>e.stopPropagation(),initial:{scale:.9,y:40,opacity:0},animate:{scale:1,y:0,opacity:1},exit:{scale:.9,y:40,opacity:0},transition:{duration:.25,ease:`easeOut`},children:(0,i.jsx)(`div`,{className:`\r
                max-h-[90vh]\r
                overflow-y-auto\r
                modal-scroll\r
                custom-scroll\r
                p-6\r
              `,children:a})})})});function o({isOpen:e,onClose:a,onConfirm:o,titulo:s=`¿Eliminar elemento?`,nombre:c=`este elemento`,isLoading:l=!1}){return(0,i.jsx)(r,{children:e&&(0,i.jsx)(n.div,{className:`
            fixed inset-0 z-50
            flex items-center justify-center
            bg-[#0B2240]/45
            backdrop-blur-sm
            p-4
          `,onClick:a,initial:{opacity:0},animate:{opacity:1},exit:{opacity:0},transition:{duration:.2},children:(0,i.jsxs)(n.div,{onClick:e=>e.stopPropagation(),className:`
              w-full
              max-w-105
              bg-white
              rounded-4xl
              p-8
              shadow-2xl
              border border-gray-100
              flex flex-col
              items-center
              text-center
            `,initial:{opacity:0,scale:.9,y:30},animate:{opacity:1,scale:1,y:0},exit:{opacity:0,scale:.9,y:30},transition:{duration:.25,ease:`easeOut`},children:[(0,i.jsx)(n.div,{className:`
                w-16 h-16
                rounded-full
                bg-red-50
                flex items-center justify-center
                mb-6
              `,initial:{scale:0},animate:{scale:1},transition:{delay:.1,type:`spring`,stiffness:300},children:(0,i.jsx)(t,{size:30,className:`text-[#E50914]`})}),(0,i.jsx)(`h2`,{className:`
                text-xl
                font-extrabold
                text-[#0B2240]
                tracking-tight
                mb-3
              `,children:s}),(0,i.jsxs)(`p`,{className:`
                text-sm
                text-gray-500
                leading-relaxed
                mb-8
              `,children:[`Se eliminará`,` `,(0,i.jsxs)(`span`,{className:`font-bold text-[#0B2240]`,children:[`"`,c,`"`]}),`.`,(0,i.jsx)(`br`,{}),`Esta acción no se puede deshacer.`]}),(0,i.jsxs)(`div`,{className:`grid grid-cols-2 gap-4 w-full`,children:[(0,i.jsx)(n.button,{whileHover:l?{}:{scale:1.02},whileTap:l?{}:{scale:.98},onClick:a,disabled:l,className:`
                  py-3 px-5
                  rounded-2xl
                  border border-gray-200
                  text-sm font-bold
                  text-[#0B2240]
                  hover:bg-gray-50
                  transition-colors
                  cursor-pointer
                  disabled:opacity-60
                  disabled:cursor-not-allowed
                `,children:`Cancelar`}),(0,i.jsx)(n.button,{whileHover:l?{}:{scale:1.02},whileTap:l?{}:{scale:.98},onClick:o,disabled:l,className:`
                  py-3 px-5
                  rounded-2xl
                  bg-[#E50914]
                  text-white
                  text-sm font-bold
                  hover:bg-[#c40811]
                  shadow-md
                  shadow-red-500/10
                  transition-all
                  cursor-pointer
                  disabled:opacity-60
                  disabled:cursor-not-allowed
                `,children:l?(0,i.jsxs)(`div`,{className:`flex items-center justify-center gap-2`,children:[(0,i.jsx)(n.div,{className:`
                        w-4 h-4
                        border-2
                        border-white/30
                        border-t-white
                        rounded-full
                      `,animate:{rotate:360},transition:{duration:.8,repeat:1/0,ease:`linear`}}),`Eliminando...`]}):`Eliminar`})]})]})})})}export{a as n,o as t};